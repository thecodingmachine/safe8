<?php

declare(strict_types=1);

namespace Safe;

use PHPUnit\Framework\TestCase;

class PureFunctionIdentifierTest extends TestCase
{
    /**
     * @dataProvider provideFunctions
     */
    public function testIsFunctionPure(bool $expected, string $functionName): void
    {
        $this->assertSame($expected, PureFunctionIdentifier::isFunctionPure($functionName));
    }

    public function provideFunctions(): iterable
    {
        foreach ($this->pureFunctions() as $pureFunction) {
            yield $pureFunction => [true, $pureFunction];
        }
        
        foreach ($this->impureFunctions() as $impureFunction) {
            yield $impureFunction => [false, $impureFunction];
        }
        
    }

    private function pureFunctions(): array
    {
        return ['ctype_alnum', 'sprintf', 'vsprintf'];
    }

    private function impureFunctions(): array
    {
        return [
            // file io
            'chdir', 'chgrp', 'chmod', 'chown', 'chroot', 'copy', 'file_get_contents', 'file_put_contents',
            'opendir', 'readdir', 'closedir', 'rewinddir', 'scandir',
            'fopen', 'fread', 'fwrite', 'fclose', 'touch', 'fpassthru', 'fputs', 'fscanf', 'fseek', 'flock',
            'ftruncate', 'fprintf', 'symlink', 'mkdir', 'unlink', 'rename', 'rmdir', 'popen', 'pclose',
            'fgetcsv', 'fputcsv', 'umask', 'finfo_open', 'finfo_close', 'finfo_file', 'readline_add_history',
            'stream_set_timeout', 'fgets', 'fflush', 'move_uploaded_file', 'file_exists', 'realpath', 'glob',
            'is_readable', 'is_dir', 'is_file',

            // stream/socket io
            'stream_context_set_option', 'socket_write', 'stream_set_blocking', 'socket_close',
            'socket_set_option', 'stream_set_write_buffer', 'stream_socket_enable_crypto', 'stream_copy_to_stream',
            'stream_wrapper_register',

            // meta calls
            'call_user_func', 'call_user_func_array', 'define', 'create_function',

            // http
            'header', 'header_remove', 'http_response_code', 'setcookie',

            // output buffer
            'ob_start', 'ob_end_clean', 'ob_get_clean', 'readfile', 'printf', 'var_dump', 'phpinfo',
            'ob_implicit_flush', 'vprintf',

            // mcrypt
            'mcrypt_generic_init', 'mcrypt_generic_deinit', 'mcrypt_module_close',

            // internal optimisation
            'clearstatcache',

            // process-related
            'pcntl_signal', 'posix_kill', 'cli_set_process_title', 'pcntl_async_signals', 'proc_close',
            'proc_nice', 'proc_open', 'proc_terminate',

            // curl
            'curl_setopt', 'curl_close', 'curl_multi_add_handle', 'curl_multi_remove_handle',
            'curl_multi_select', 'curl_multi_close', 'curl_setopt_array',

            // apc, apcu
            'apc_store', 'apc_delete', 'apc_clear_cache', 'apc_add', 'apc_inc', 'apc_dec', 'apc_cas',
            'apcu_store', 'apcu_delete', 'apcu_clear_cache', 'apcu_add', 'apcu_inc', 'apcu_dec', 'apcu_cas',

            // gz
            'gzwrite', 'gzrewind', 'gzseek', 'gzclose',

            // newrelic
            'newrelic_start_transaction', 'newrelic_name_transaction', 'newrelic_add_custom_parameter',
            'newrelic_add_custom_tracer', 'newrelic_background_job', 'newrelic_end_transaction',
            'newrelic_set_appname',

            // execution
            'shell_exec', 'exec', 'system', 'passthru', 'pcntl_exec',

            // well-known functions
            'libxml_use_internal_errors', 'libxml_disable_entity_loader', 'curl_exec',
            'mt_srand', 'openssl_pkcs7_sign',
            'mt_rand', 'rand', 'random_int', 'random_bytes',
            'wincache_ucache_delete', 'wincache_ucache_set', 'wincache_ucache_inc',
            'class_alias',
            'class_exists', // impure by virtue of triggering autoloader

            // php environment
            'ini_set', 'sleep', 'usleep', 'register_shutdown_function',
            'error_reporting', 'register_tick_function', 'unregister_tick_function',
            'set_error_handler', 'user_error', 'trigger_error', 'restore_error_handler',
            'date_default_timezone_set', 'assert_options', 'setlocale',
            'set_exception_handler', 'set_time_limit', 'putenv', 'spl_autoload_register',
            'spl_autoload_unregister', 'microtime', 'array_rand', 'set_include_path',

            // logging
            'openlog', 'syslog', 'error_log', 'define_syslog_variables',

            // session
            'session_id', 'session_decode', 'session_name', 'session_set_cookie_params',
            'session_set_save_handler', 'session_regenerate_id', 'mb_internal_encoding',
            'session_start', 'session_cache_limiter',

            // ldap
            'ldap_set_option',

            // iterators
            'rewind', 'iterator_apply', 'iterator_to_array',

            // mysqli
            'mysqli_select_db', 'mysqli_dump_debug_info', 'mysqli_kill', 'mysqli_multi_query',
            'mysqli_next_result', 'mysqli_options', 'mysqli_ping', 'mysqli_query', 'mysqli_report',
            'mysqli_rollback', 'mysqli_savepoint', 'mysqli_set_charset', 'mysqli_ssl_set', 'mysqli_close',

            // script execution
            'ignore_user_abort',

            // ftp
            'ftp_close',

            // bcmath
            'bcscale',

            // json
            'json_last_error',

            // opcache
            'opcache_compile_file', 'opcache_get_configuration', 'opcache_get_status',
            'opcache_invalidate', 'opcache_is_script_cached', 'opcache_reset',

            //gettext
            'bindtextdomain',

            // debug
            'var_export', 'print_r',

            // image
            'imagecopy',
        ];
    }
}
