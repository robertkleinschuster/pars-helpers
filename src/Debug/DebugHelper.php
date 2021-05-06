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
    protected static array $debugList = [];
    /**
     * @param $obj
     * @param int $level
     */
    public static function trace($obj, int $level = 15)
    {
        self::$debugList[] = [
            'object' => $obj,
            'trace' => debug_backtrace(null, $level)
        ];
        $debug = self::getBacktrace($level);
        $debug .= '<pre><br><br>--------------DUMP--------------<br><br>';
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

    public static function getBacktrace(int $level = 15, array $ignoreFunctions = [], array $ignoreClasses = []): string
    {
        $trace = debug_backtrace(null, 20);
        foreach ($trace as $key => $item) {
            if (isset($item['class']) && in_array($item['class'],  $ignoreClasses)) {
                unset($trace[$key]);
            }
            if (in_array($item['function'], array_merge(['trace', 'pars_debug', 'getBacktrace'], $ignoreFunctions))) {
                unset($trace[$key]);
            }
        }
        $trace = array_slice($trace, 0, $level);
        $item = reset($trace);

        $class = $item['class'] ?? null;
        $function =  $item['function'] ?? '';
        $line =  $item['line'] ?? '';
        $debug = '<pre style="font-size: 14px; font-weight: bolder">DEBUG: ' . $class . ':' .$function . ':' . $line . '</pre>';
        $debug .= '<pre style="font-size: 13px">';
        $debug .= '<br>--------------TRACE--------------<br>';
        foreach ($trace as $i => $item) {
            $class = $item['class'] ?? null;
            $debug .= '<br>#' . $i . ' - ' . $class . ':' . $item['function'] ?? '' . ':' . $item['line'] ?? '';
        }
        $debug .= '</pre>';
        return $debug;
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

    /**
     * @return array
     */
    public static function getDebugList(): array
    {
        return self::$debugList;
    }


}
