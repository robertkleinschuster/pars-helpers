<?php


namespace Pars\Helper\Debug;

/**
 * Class DebugHelper
 * @package Pars\Helper\Debug
 */
class DebugHelper
{
    /**
     * @var string|null
     */
    protected static ?string $debug = null;

    /**
     * @param $obj
     * @param int $level
     */
    public static function trace($obj, int $level = 10)
    {
        $trace = debug_backtrace(null, $level);
        $item = $trace[0];
        while (in_array($item['function'], ['trace', 'pars_debug'])) {
            array_shift($trace);
            $item = $trace[0];
        }
        $class = $item['class'] ?? null;
        $debug = '<pre style="font-size: 14px; font-weight: bolder">DEBUG: ' . $class . ':' . $item['function'] . ':' . $item['line'] . '</pre>';
        $debug .= '<pre style="font-size: 13px">';
        $debug .= '<br>--------------TRACE--------------<br>';
        foreach ($trace as $i => $item) {
            $class = $item['class'] ?? null;
            $debug .= '<br>#' . $i . ' - ' . $class . ':' . $item['function'] . ':' . $item['line'];
        }
        $debug .= '<br><br>--------------DUMP--------------<br><br>';
        if (is_scalar($obj)) {
            $dump = var_export($obj, true);
        } else {
            ob_start();
            var_dump($obj);
            $dump = ob_get_clean();
            $dump = preg_replace('/^.+\n/', '', $dump);
            $dump = preg_replace('/^.+\n/', '', $dump);
        }
        $debug .= $dump;
        $debug .= '</pre>';
        self::$debug .= $debug . '<br>';
    }

    /**
     * @return string
     */
    public static function getDebug(): ?string
    {
        return self::$debug;
    }

    /**
     * @return bool
     */
    public static function hasDebug(): bool
    {
        return isset(self::$debug);
    }
}
