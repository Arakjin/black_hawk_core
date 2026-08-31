<?php
namespace BlackHawkSolutions;

class Solver {
    private $target;
    private $reusedColor;

    public function __construct($target) {
        $this->target = $target;
        $this->reusedColor = new Color(0, 0, 0);
    }

    public function solve() {
        $wideResult = $this->solveWide();
        $narrowResult = $this->solveNarrow($wideResult);

        $cssFilter = $this->css($narrowResult['values']);

        return $cssFilter;
    }

    private function solveWide() {
        $A = 5;
        $c = 15;
        $a = [60, 180, 18000, 600, 1.2, 1.2];
        $best = ['loss' => PHP_INT_MAX, 'values' => null];

        for ($i = 0; $best['loss'] > 25 && $i < 3; $i++) {
            $initial = [50, 20, 3750, 50, 100, 100];
            $result = $this->spsa($A, $a, $c, $initial, 1000);
            if ($result['loss'] < $best['loss']) {
                $best = $result;
            }
        }

        return $best;
    }

    private function solveNarrow($wide) {
        $A = $wide['loss'];
        $c = 2;
        $a = array_map(fn($x) => $x * (1 + $A), [0.25, 0.25, 1, 0.25, 0.2, 0.2]);

        return $this->spsa($A, $a, $c, $wide['values'], 500);
    }

    private function spsa($A, $a, $c, $values, $iters) {
        $alpha = 1;
        $gamma = 1 / 6;

        $best = ['values' => $values, 'loss' => PHP_INT_MAX];

        for ($k = 0; $k < $iters; $k++) {
            $ck = $c / pow($k + 1, $gamma);
            $deltas = [];
            $highArgs = [];
            $lowArgs = [];

            for ($i = 0; $i < count($values); $i++) {
                $deltas[$i] = mt_rand(0, 1) ? 1 : -1;
                $highArgs[$i] = $values[$i] + $ck * $deltas[$i];
                $lowArgs[$i] = $values[$i] - $ck * $deltas[$i];
            }

            $lossDiff = $this->loss($highArgs) - $this->loss($lowArgs);
            for ($i = 0; $i < count($values); $i++) {
                $gradient = $lossDiff / (2 * $ck) * $deltas[$i];
                $values[$i] = max(0, min($this->getMaxValue($i), $values[$i] - $a[$i] / pow($A + $k + 1, $alpha) * $gradient));
            }

            $currentLoss = $this->loss($values);

            if ($currentLoss < $best['loss']) {
                $best = ['values' => $values, 'loss' => $currentLoss];
            }
        }

        return $best;
    }

    private function loss($filters) {
        $color = $this->reusedColor;
        $color->set(0, 0, 0);

        $color->invert($filters[0] / 100);
        $color->sepia($filters[1] / 100);
        $color->saturate($filters[2] / 100);
        $color->hueRotate($filters[3] * 3.6);
        $color->brightness($filters[4] / 100);
        $color->contrast($filters[5] / 100);

        $colorHSL = $color->hsl();
        $targetHSL = $this->target->hsl();

        return abs($color->r - $this->target->r) +
               abs($color->g - $this->target->g) +
               abs($color->b - $this->target->b) +
               abs($colorHSL['h'] - $targetHSL['h']) +
               abs($colorHSL['s'] - $targetHSL['s']) +
               abs($colorHSL['l'] - $targetHSL['l']);
    }

    private function getMaxValue($index) {
        switch ($index) {
            case 2: return 7500; // Saturate
            case 4: case 5: return 200; // Brightness, Contrast
            case 3: return 100; // Hue-rotate
            default: return 100; // Invert, Sepia
        }
    }

    private function css($filters) {
        $baseAdjustment = "brightness(0) saturate(100%) ";

        return $baseAdjustment . sprintf(
            "invert(%d%%) sepia(%d%%) saturate(%d%%) hue-rotate(%ddeg) brightness(%d%%) contrast(%d%%);",
            round($filters[0]), round($filters[1]), round($filters[2]),
            round($filters[3] * 3.6), round($filters[4]), round($filters[5])
        );
    }
}



class Color {
    public $r, $g, $b;

    public function __construct($r, $g, $b) {
        $this->set($r, $g, $b);
    }

    public function set($r, $g, $b) {
        $this->r = $this->clamp($r);
        $this->g = $this->clamp($g);
        $this->b = $this->clamp($b);
    }

    public function invert($value = 1) {
        $this->r = $this->clamp(($value + $this->r / 255 * (1 - 2 * $value)) * 255);
        $this->g = $this->clamp(($value + $this->g / 255 * (1 - 2 * $value)) * 255);
        $this->b = $this->clamp(($value + $this->b / 255 * (1 - 2 * $value)) * 255);
    }

    public function sepia($value = 1) {
        $this->multiply([
            0.393 + 0.607 * (1 - $value),
            0.769 - 0.769 * (1 - $value),
            0.189 - 0.189 * (1 - $value),
            0.349 - 0.349 * (1 - $value),
            0.686 + 0.314 * (1 - $value),
            0.168 - 0.168 * (1 - $value),
            0.272 - 0.272 * (1 - $value),
            0.534 - 0.534 * (1 - $value),
            0.131 + 0.869 * (1 - $value)
        ]);
    }

    public function saturate($value = 1) {
        $this->multiply([
            0.213 + 0.787 * $value,
            0.715 - 0.715 * $value,
            0.072 - 0.072 * $value,
            0.213 - 0.213 * $value,
            0.715 + 0.285 * $value,
            0.072 - 0.072 * $value,
            0.213 - 0.213 * $value,
            0.715 - 0.715 * $value,
            0.072 + 0.928 * $value
        ]);
    }

    public function brightness($value = 1) {
        $this->linear($value);
    }

    public function contrast($value = 1) {
        $this->linear($value, -(0.5 * $value) + 0.5);
    }

    public function hueRotate($angle = 0) {
        $angle = $angle / 180 * pi();
        $sin = sin($angle);
        $cos = cos($angle);

        $this->multiply([
            0.213 + $cos * 0.787 - $sin * 0.213,
            0.715 - $cos * 0.715 - $sin * 0.715,
            0.072 - $cos * 0.072 + $sin * 0.928,
            0.213 - $cos * 0.213 + $sin * 0.143,
            0.715 + $cos * 0.285 + $sin * 0.140,
            0.072 - $cos * 0.072 - $sin * 0.283,
            0.213 - $cos * 0.213 - $sin * 0.787,
            0.715 - $cos * 0.715 + $sin * 0.715,
            0.072 + $cos * 0.928 + $sin * 0.072
        ]);
    }

    public function hsl() {
        // Normalize RGB values to [0, 1]
        $r = $this->r / 255;
        $g = $this->g / 255;
        $b = $this->b / 255;

        // Find min and max values
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $delta = $max - $min;

        // Calculate lightness
        $l = ($max + $min) / 2;

        // Initialize hue and saturation
        $h = $s = 0;

        if ($delta > 0) {
            // Calculate saturation
            $s = $l > 0.5 ? $delta / (2 - $max - $min) : $delta / ($max + $min);

            // Calculate hue
            if ($max === $r) {
                $h = ($g - $b) / $delta + ($g < $b ? 6 : 0);
            } elseif ($max === $g) {
                $h = ($b - $r) / $delta + 2;
            } elseif ($max === $b) {
                $h = ($r - $g) / $delta + 4;
            }
            $h /= 6;
        }

        // Convert to percentages
        return [
            'h' => $h * 100, // Hue in range [0, 100]
            's' => $s * 100, // Saturation in range [0, 100]
            'l' => $l * 100  // Lightness in range [0, 100]
        ];
    }
    
    private function linear($slope = 1, $intercept = 0) {
        $this->r = $this->clamp($this->r * $slope + $intercept * 255);
        $this->g = $this->clamp($this->g * $slope + $intercept * 255);
        $this->b = $this->clamp($this->b * $slope + $intercept * 255);
    }

    private function multiply($matrix) {
        $newR = $this->clamp($this->r * $matrix[0] + $this->g * $matrix[1] + $this->b * $matrix[2]);
        $newG = $this->clamp($this->r * $matrix[3] + $this->g * $matrix[4] + $this->b * $matrix[5]);
        $newB = $this->clamp($this->r * $matrix[6] + $this->g * $matrix[7] + $this->b * $matrix[8]);

        $this->r = $newR;
        $this->g = $newG;
        $this->b = $newB;
    }

    private function clamp($value) {
        return max(0, min(255, $value));
    }
}




function black_hawk_solutions_sanitize_hex_color($color)
{
    // Trim whitespace and convert the color to lowercase for consistency
    $color = trim(strtolower($color));

    // Check if the color starts with '#' and add it if it's missing
    if ($color && strpos($color, '#') !== 0) {
        $color = '#' . $color;
    }

    // Use WordPress's built-in function to sanitize the color
    $sanitized_color = sanitize_hex_color($color);

    // Additional check to handle invalid color formats
    if (null === $sanitized_color) {
        // Output an error message in the console if the color is invalid
        echo '<script>console.log("Invalid Color:", "' . esc_js($color) . '");</script>';
        return ''; // Return an empty string or a default value if needed
    }

    // Return the correctly formatted and sanitized color
    return $sanitized_color;
}

function black_hawk_solutions_allowed_html() {
    return array(
        'i' => array(
            'class' => array(), // Allow the 'class' attribute for Font Awesome icons
        ),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
        ),
        'br' => array(), // Allow line breaks
        'p' => array(),  // Allow paragraphs
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array()
    );
}
// Custom sanitization function to allow Font Awesome <i> tags
function black_hawk_solutions_sanitize_fontawesome_html($input) {
    // Define allowed tags and attributes
    $allowed_tags = array(
        'i' => array(
            'class' => array(),  // Allow the 'class' attribute for <i> tags
        ),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
        ),
        'br' => array(),
        'p' => array(),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array()
    );

    return wp_kses($input, $allowed_tags);
}

function hex_to_rgb($hex) {
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) === 3) {
        $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
        $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
        $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    return [$r, $g, $b];
}

function generate_css_filter($hexColor) {
    $rgb = hex_to_rgb($hexColor);
    if (count($rgb) !== 3) {
        throw new \Exception("Invalid color format!");
    }

    $color = new Color($rgb[0], $rgb[1], $rgb[2]);
    $solver = new Solver($color);

    return $solver->solve();
}
?>
