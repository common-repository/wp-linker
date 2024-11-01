<?php
declare(strict_types=1);

namespace SoftwareHut\WPLinker;

use DateTime;

class Logger
{
    /**
     * @param string $type
     * @param array $data
     */
    public static function log( $type, $data )
    {
        $logDir = plugin_dir_path( dirname( __FILE__ ) ) . 'logs/';
        $logFileName = $type . '_log_' . ( new DateTime() )->format( 'd_m_y' ) . '.log';


        $params = [
            'created'  => ( new DateTime() )->format( 'd.m.y H:i:s' ),
            print_r($data, true)
        ];

        file_put_contents( $logDir . $logFileName, implode(' | ', $params) . "\n", FILE_APPEND );
    }
}
