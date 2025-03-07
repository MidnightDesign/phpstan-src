<?php // phpcs:ignoreFile

/**
 * Copied over from https://github.com/phan/phan/blob/8866d6b98be94b37996390da226e8c4befea29aa/src/Phan/Language/Internal/FunctionSignatureMap_php80_delta.php
 * Copyright (c) 2015 Rasmus Lerdorf
 * Copyright (c) 2015 Andrew Morrison
 */

/**
 * This contains the information needed to convert the function signatures for php 8.0 to php 7.4 (and vice versa)
 *
 * This has two sections.
 * The 'new' section contains function/method names from FunctionSignatureMap (And alternates, if applicable) that do not exist in php7.4 or have different signatures in php 8.0.
 *   If they were just updated, the function/method will be present in the 'added' signatures.
 * The 'old' signatures contains the signatures that are different in php 7.4.
 *   Functions are expected to be removed only in major releases of php.
 *
 * @see FunctionSignatureMap.php
 *
 * @phan-file-suppress PhanPluginMixedKeyNoKey (read by Phan when analyzing this file)
 */
return [
	'new' => [
		'array_combine' => ['associative-array', 'keys'=>'string[]|int[]', 'values'=>'array'],
		'bcdiv' => ['string', 'dividend'=>'string', 'divisor'=>'string', 'scale='=>'int'],
		'bcmod' => ['string', 'dividend'=>'string', 'divisor'=>'string', 'scale='=>'int'],
		'bcpowmod' => ['string', 'base'=>'string', 'exponent'=>'string', 'modulus'=>'string', 'scale='=>'int'],
		'call_user_func_array' => ['mixed', 'function'=>'callable', 'parameters'=>'array<int|string,mixed>'],
		'com_load_typelib' => ['bool', 'typelib_name'=>'string', 'case_insensitive='=>'true'],
		'count_chars' => ['array<int,int>|string', 'input'=>'string', 'mode='=>'int'],
		'date_add' => ['DateTime', 'object'=>'DateTime', 'interval'=>'DateInterval'],
		'date_date_set' => ['DateTime', 'object'=>'DateTime', 'year'=>'int', 'month'=>'int', 'day'=>'int'],
		'date_diff' => ['DateInterval', 'obj1'=>'DateTimeInterface', 'obj2'=>'DateTimeInterface', 'absolute='=>'bool'],
		'date_format' => ['string', 'object'=>'DateTimeInterface', 'format'=>'string'],
		'date_isodate_set' => ['DateTime', 'object'=>'DateTime', 'year'=>'int', 'week'=>'int', 'day='=>'int|mixed'],
		'date_parse' => ['array<string,mixed>', 'date'=>'string'],
		'date_sub' => ['DateTime', 'object'=>'DateTime', 'interval'=>'DateInterval'],
		'date_sun_info' => ['array<string,bool|int>', 'time'=>'int', 'latitude'=>'float', 'longitude'=>'float'],
		'date_time_set' => ['DateTime', 'object'=>'DateTime', 'hour'=>'int', 'minute'=>'int', 'second='=>'int', 'microseconds='=>'int'],
		'date_timestamp_set' => ['DateTime', 'object'=>'DateTime', 'unixtimestamp'=>'int'],
		'date_timezone_set' => ['DateTime', 'object'=>'DateTime', 'timezone'=>'DateTimeZone'],
		'explode' => ['non-empty-array<int,string>', 'separator'=>'non-empty-string', 'str'=>'string', 'limit='=>'int'],
		'fdiv' => ['float', 'dividend'=>'float', 'divisor'=>'float'],
		'get_debug_type' => ['string', 'var'=>'mixed'],
		'get_resource_id' => ['int', 'res'=>'resource'],
		'gmdate' => ['string', 'format'=>'string', 'timestamp='=>'int'],
		'gmmktime' => ['int|false', 'hour'=>'int', 'minute='=>'int', 'second='=>'int', 'month='=>'int', 'day='=>'int', 'year='=>'int'],
		'hash_hkdf' => ['string', 'algo'=>'string', 'ikm'=>'string', 'length='=>'int', 'info='=>'string', 'salt='=>'string'],
		'imageaffine' => ['false|object', 'src'=>'resource', 'affine'=>'array', 'clip='=>'array'],
		'imagecreate' => ['false|object', 'x_size'=>'int', 'y_size'=>'int'],
		'imagecreatefrombmp' => ['false|object', 'filename'=>'string'],
		'imagecreatefromgd' => ['false|object', 'filename'=>'string'],
		'imagecreatefromgd2' => ['false|object', 'filename'=>'string'],
		'imagecreatefromgd2part' => ['false|object', 'filename'=>'string', 'srcx'=>'int', 'srcy'=>'int', 'width'=>'int', 'height'=>'int'],
		'imagecreatefromgif' => ['false|object', 'filename'=>'string'],
		'imagecreatefromjpeg' => ['false|object', 'filename'=>'string'],
		'imagecreatefrompng' => ['false|object', 'filename'=>'string'],
		'imagecreatefromstring' => ['false|object', 'image'=>'string'],
		'imagecreatefromwbmp' => ['false|object', 'filename'=>'string'],
		'imagecreatefromwebp' => ['false|object', 'filename'=>'string'],
		'imagecreatefromxbm' => ['false|object', 'filename'=>'string'],
		'imagecreatefromxpm' => ['false|object', 'filename'=>'string'],
		'imagecreatetruecolor' => ['false|object', 'x_size'=>'int', 'y_size'=>'int'],
		'imagecrop' => ['false|object', 'im'=>'resource', 'rect'=>'array'],
		'imagecropauto' => ['false|object', 'im'=>'resource', 'mode'=>'int', 'threshold'=>'float', 'color'=>'int'],
		'imagegetclip' => ['array<int,int>', 'im'=>'resource'],
		'imagegrabscreen' => ['false|object'],
		'imagegrabwindow' => ['false|object', 'window_handle'=>'int', 'client_area='=>'int'],
		'imagejpeg' => ['bool', 'im'=>'GdImage', 'filename='=>'string|resource|null', 'quality='=>'int'],
		'imagerotate' => ['false|object', 'src_im'=>'resource', 'angle'=>'float', 'bgdcolor'=>'int', 'ignoretransparent='=>'int'],
		'imagescale' => ['false|object', 'im'=>'resource', 'new_width'=>'int', 'new_height='=>'int', 'method='=>'int'],
		'ldap_set_rebind_proc' => ['bool', 'ldap'=>'resource', 'callback'=>'?callable'],
		'mb_decode_numericentity' => ['string|false', 'string'=>'string', 'convmap'=>'array', 'encoding='=>'string'],
		'mb_str_split' => ['non-empty-array<int,string>', 'str'=>'string', 'split_length='=>'positive-int', 'encoding='=>'string'],
		'mktime' => ['int|false', 'hour'=>'int', 'minute='=>'int', 'second='=>'int', 'month='=>'int', 'day='=>'int', 'year='=>'int'],
		'odbc_exec' => ['resource|false', 'connection_id'=>'resource', 'query'=>'string'],
		'parse_str' => ['void', 'encoded_string'=>'string', '&w_result'=>'array'],
		'password_hash' => ['string', 'password'=>'string', 'algo'=>'string|int|null', 'options='=>'array'],
		'PhpToken::tokenize' => ['list<PhpToken>', 'code'=>'string', 'flags='=>'int'],
		'PhpToken::is' => ['bool', 'kind'=>'string|int|string[]|int[]'],
		'PhpToken::isIgnorable' => ['bool'],
		'PhpToken::getTokenName' => ['string'],
		'proc_get_status' => ['array{command: string, pid: int, running: bool, signaled: bool, stopped: bool, exitcode: int, termsig: int, stopsig: int}', 'process'=>'resource'],
		'socket_addrinfo_lookup' => ['AddressInfo[]', 'node'=>'string', 'service='=>'mixed', 'hints='=>'array'],
		'socket_select' => ['int|false', '&rw_read'=>'Socket[]|null', '&rw_write'=>'Socket[]|null', '&rw_except'=>'Socket[]|null', 'seconds'=>'int|null', 'microseconds='=>'int'],
		'sodium_crypto_aead_chacha20poly1305_ietf_decrypt' => ['string|false', 'confidential_message'=>'string', 'public_message'=>'string', 'nonce'=>'string', 'key'=>'string'],
		'str_contains' => ['bool', 'haystack'=>'string', 'needle'=>'string'],
		'str_split' => ['non-empty-array<int,string>', 'str'=>'string', 'split_length='=>'positive-int'],
		'str_ends_with' => ['bool', 'haystack'=>'string', 'needle'=>'string'],
		'str_starts_with' => ['bool', 'haystack'=>'string', 'needle'=>'string'],
		'strchr' => ['string|false', 'haystack'=>'string', 'needle'=>'string', 'before_needle='=>'bool'],
		'stripos' => ['int|false', 'haystack'=>'string', 'needle'=>'string', 'offset='=>'int'],
		'stristr' => ['string|false', 'haystack'=>'string', 'needle'=>'string', 'before_needle='=>'bool'],
		'strpos' => ['positive-int|0|false', 'haystack'=>'string', 'needle'=>'string', 'offset='=>'int'],
		'strrchr' => ['string|false', 'haystack'=>'string', 'needle'=>'string'],
		'strripos' => ['int|false', 'haystack'=>'string', 'needle'=>'string', 'offset='=>'int'],
		'strrpos' => ['int|false', 'haystack'=>'string', 'needle'=>'string', 'offset='=>'int'],
		'strstr' => ['string|false', 'haystack'=>'string', 'needle'=>'string', 'before_needle='=>'bool'],
		'version_compare' => ['int|bool', 'version1'=>'string', 'version2'=>'string', 'operator='=>'string'],
		'xml_parser_create' => ['XMLParser', 'encoding='=>'string'],
		'xml_parser_create_ns' => ['XMLParser', 'encoding='=>'string', 'sep='=>'string'],
		'xml_parser_free' => ['bool', 'parser'=>'XMLParser'],
		'xml_parser_get_option' => ['mixed|false', 'parser'=>'XMLParser', 'option'=>'int'],
		'xml_parser_set_option' => ['bool', 'parser'=>'XMLParser', 'option'=>'int', 'value'=>'mixed'],
		'xmlwriter_end_attribute' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_end_cdata' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_end_comment' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_end_document' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_end_dtd' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_end_dtd_attlist' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_end_dtd_element' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_end_dtd_entity' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_end_element' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_end_pi' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_flush' => ['mixed', 'xmlwriter'=>'XMLWriter', 'empty='=>'bool'],
		'xmlwriter_full_end_element' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_open_memory' => ['XMLWriter'],
		'xmlwriter_open_uri' => ['XMLWriter', 'source'=>'string'],
		'xmlwriter_output_memory' => ['string', 'xmlwriter'=>'XMLWriter', 'flush='=>'bool'],
		'xmlwriter_set_indent' => ['bool', 'xmlwriter'=>'XMLWriter', 'indent'=>'bool'],
		'xmlwriter_set_indent_string' => ['bool', 'xmlwriter'=>'XMLWriter', 'indentstring'=>'string'],
		'xmlwriter_start_attribute' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string'],
		'xmlwriter_start_attribute_ns' => ['bool', 'xmlwriter'=>'XMLWriter', 'prefix'=>'string', 'name'=>'string', 'uri'=>'string'],
		'xmlwriter_start_cdata' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_start_comment' => ['bool', 'xmlwriter'=>'XMLWriter'],
		'xmlwriter_start_document' => ['bool', 'xmlwriter'=>'XMLWriter', 'version='=>'string', 'encoding='=>'string', 'standalone='=>'string'],
		'xmlwriter_start_dtd' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string', 'publicid='=>'string', 'sysid='=>'string'],
		'xmlwriter_start_dtd_attlist' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string'],
		'xmlwriter_start_dtd_element' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string'],
		'xmlwriter_start_dtd_entity' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string', 'isparam'=>'bool'],
		'xmlwriter_start_element' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string'],
		'xmlwriter_start_element_ns' => ['bool', 'xmlwriter'=>'XMLWriter', 'prefix'=>'string', 'name'=>'string', 'uri'=>'string'],
		'xmlwriter_start_pi' => ['bool', 'xmlwriter'=>'XMLWriter', 'target'=>'string'],
		'xmlwriter_text' => ['bool', 'xmlwriter'=>'XMLWriter', 'content'=>'string'],
		'xmlwriter_write_attribute' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string', 'content'=>'string'],
		'xmlwriter_write_attribute_ns' => ['bool', 'xmlwriter'=>'XMLWriter', 'prefix'=>'string', 'name'=>'string', 'uri'=>'string', 'content'=>'string'],
		'xmlwriter_write_cdata' => ['bool', 'xmlwriter'=>'XMLWriter', 'content'=>'string'],
		'xmlwriter_write_comment' => ['bool', 'xmlwriter'=>'XMLWriter', 'content'=>'string'],
		'xmlwriter_write_dtd' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string', 'publicid='=>'string', 'sysid='=>'string', 'subset='=>'string'],
		'xmlwriter_write_dtd_attlist' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string', 'content'=>'string'],
		'xmlwriter_write_dtd_element' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string', 'content'=>'string'],
		'xmlwriter_write_dtd_entity' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string', 'content'=>'string', 'pe'=>'bool', 'publicid'=>'string', 'sysid'=>'string', 'ndataid'=>'string'],
		'xmlwriter_write_element' => ['bool', 'xmlwriter'=>'XMLWriter', 'name'=>'string', 'content'=>'string'],
		'xmlwriter_write_element_ns' => ['bool', 'xmlwriter'=>'XMLWriter', 'prefix'=>'string', 'name'=>'string', 'uri'=>'string', 'content'=>'string'],
		'xmlwriter_write_pi' => ['bool', 'xmlwriter'=>'XMLWriter', 'target'=>'string', 'content'=>'string'],
		'xmlwriter_write_raw' => ['bool', 'xmlwriter'=>'XMLWriter', 'content'=>'string'],
	],
	'old' => [

		'array_combine' => ['associative-array|false', 'keys'=>'string[]|int[]', 'values'=>'array'],
		'bcdiv' => ['?string', 'dividend'=>'string', 'divisor'=>'string', 'scale='=>'int'],
		'bcmod' => ['?string', 'dividend'=>'string', 'divisor'=>'string', 'scale='=>'int'],
		'bcpowmod' => ['?string', 'base'=>'string', 'exponent'=>'string', 'modulus'=>'string', 'scale='=>'int'],
		'com_load_typelib' => ['bool', 'typelib_name'=>'string', 'case_insensitive='=>'bool'],
		'count_chars' => ['array<int,int>|false|string', 'input'=>'string', 'mode='=>'int'],
		'date_add' => ['DateTime|false', 'object'=>'DateTime', 'interval'=>'DateInterval'],
		'date_date_set' => ['DateTime|false', 'object'=>'DateTime', 'year'=>'int', 'month'=>'int', 'day'=>'int'],
		'date_diff' => ['DateInterval|false', 'obj1'=>'DateTimeInterface', 'obj2'=>'DateTimeInterface', 'absolute='=>'bool'],
		'date_format' => ['string|false', 'object'=>'DateTimeInterface', 'format'=>'string'],
		'date_isodate_set' => ['DateTime|false', 'object'=>'DateTime', 'year'=>'int', 'week'=>'int', 'day='=>'int|mixed'],
		'date_parse' => ['array<string,mixed>|false', 'date'=>'string'],
		'date_sub' => ['DateTime|false', 'object'=>'DateTime', 'interval'=>'DateInterval'],
		'date_sun_info' => ['array<string,bool|int>|false', 'time'=>'int', 'latitude'=>'float', 'longitude'=>'float'],
		'date_time_set' => ['DateTime|false', 'object'=>'DateTime', 'hour'=>'int', 'minute'=>'int', 'second='=>'int', 'microseconds='=>'int'],
		'date_timestamp_set' => ['DateTime|false', 'object'=>'DateTime', 'unixtimestamp'=>'int'],
		'date_timezone_set' => ['DateTime|false', 'object'=>'DateTime', 'timezone'=>'DateTimeZone'],
		'each' => ['array{0:int|string,key:int|string,1:mixed,value:mixed}', '&r_arr'=>'array'],
		'gmdate' => ['string|false', 'format'=>'string', 'timestamp='=>'int'],
		'gmmktime' => ['int|false', 'hour='=>'int', 'minute='=>'int', 'second='=>'int', 'month='=>'int', 'day='=>'int', 'year='=>'int'],
		'gmp_random' => ['GMP', 'limiter='=>'int'],
		'gzgetss' => ['string|false', 'zp'=>'resource', 'length'=>'int', 'allowable_tags='=>'string'],
		'hash_hkdf' => ['string|false', 'algo'=>'string', 'ikm'=>'string', 'length='=>'int', 'info='=>'string', 'salt='=>'string'],
		'image2wbmp' => ['bool', 'im'=>'resource', 'filename='=>'?string', 'threshold='=>'int'],
		'imageaffine' => ['resource|false', 'src'=>'resource', 'affine'=>'array', 'clip='=>'array'],
		'imagecreate' => ['resource|false', 'x_size'=>'int', 'y_size'=>'int'],
		'imagecreatefrombmp' => ['resource|false', 'filename'=>'string'],
		'imagecreatefromgd' => ['resource|false', 'filename'=>'string'],
		'imagecreatefromgd2' => ['resource|false', 'filename'=>'string'],
		'imagecreatefromgd2part' => ['resource|false', 'filename'=>'string', 'srcx'=>'int', 'srcy'=>'int', 'width'=>'int', 'height'=>'int'],
		'imagecreatefromgif' => ['resource|false', 'filename'=>'string'],
		'imagecreatefromjpeg' => ['resource|false', 'filename'=>'string'],
		'imagecreatefrompng' => ['resource|false', 'filename'=>'string'],
		'imagecreatefromstring' => ['resource|false', 'image'=>'string'],
		'imagecreatefromwbmp' => ['resource|false', 'filename'=>'string'],
		'imagecreatefromwebp' => ['resource|false', 'filename'=>'string'],
		'imagecreatefromxbm' => ['resource|false', 'filename'=>'string'],
		'imagecreatefromxpm' => ['resource|false', 'filename'=>'string'],
		'imagecreatetruecolor' => ['resource|false', 'x_size'=>'int', 'y_size'=>'int'],
		'imagecrop' => ['resource|false', 'im'=>'resource', 'rect'=>'array'],
		'imagecropauto' => ['resource|false', 'im'=>'resource', 'mode'=>'int', 'threshold'=>'float', 'color'=>'int'],
		'imagegetclip' => ['array<int,int>|false', 'im'=>'resource'],
		'imagegrabscreen' => ['false|resource'],
		'imagegrabwindow' => ['false|resource', 'window_handle'=>'int', 'client_area='=>'int'],
		'imagejpeg' => ['bool', 'im'=>'resource', 'filename='=>'string|resource|null', 'quality='=>'int'],
		'imagerotate' => ['resource|false', 'src_im'=>'resource', 'angle'=>'float', 'bgdcolor'=>'int', 'ignoretransparent='=>'int'],
		'imagescale' => ['resource|false', 'im'=>'resource', 'new_width'=>'int', 'new_height='=>'int', 'method='=>'int'],
		'implode\'1' => ['string', 'pieces'=>'array'],
		'jpeg2wbmp' => ['bool', 'jpegname'=>'string', 'wbmpname'=>'string', 'dest_height'=>'int', 'dest_width'=>'int', 'threshold'=>'int'],
		'ldap_set_rebind_proc' => ['bool', 'link_identifier'=>'resource', 'callback'=>'callable'],
		'ldap_sort' => ['bool', 'link_identifier'=>'resource', 'result_identifier'=>'resource', 'sortfilter'=>'string'],
		'mb_decode_numericentity' => ['string|false', 'string'=>'string', 'convmap'=>'array', 'encoding='=>'string', 'is_hex='=>'bool'],
		'mktime' => ['int|false', 'hour='=>'int', 'minute='=>'int', 'second='=>'int', 'month='=>'int', 'day='=>'int', 'year='=>'int'],
		'odbc_exec' => ['resource|false', 'connection_id'=>'resource', 'query'=>'string', 'flags='=>'int'],
		'parse_str' => ['void', 'encoded_string'=>'string', '&w_result='=>'array'],
		'password_hash' => ['string|false|null', 'password'=>'string', 'algo'=>'?string|?int', 'options='=>'array'],
		'png2wbmp' => ['bool', 'pngname'=>'string', 'wbmpname'=>'string', 'dest_height'=>'int', 'dest_width'=>'int', 'threshold'=>'int'],
		'proc_get_status' => ['array{command: string, pid: int, running: bool, signaled: bool, stopped: bool, exitcode: int, termsig: int, stopsig: int}|false', 'process'=>'resource'],
		'read_exif_data' => ['array', 'filename'=>'string', 'sections_needed='=>'string', 'sub_arrays='=>'bool', 'read_thumbnail='=>'bool'],
		'socket_select' => ['int|false', '&rw_read_fds'=>'resource[]|null', '&rw_write_fds'=>'resource[]|null', '&rw_except_fds'=>'resource[]|null', 'tv_sec'=>'int|null', 'tv_usec='=>'int|null'],
		'sodium_crypto_aead_chacha20poly1305_ietf_decrypt' => ['?string|?false', 'confidential_message'=>'string', 'public_message'=>'string', 'nonce'=>'string', 'key'=>'string'],
		'SplFileObject::fgetss' => ['string|false', 'allowable_tags='=>'string'],
		'strchr' => ['string|false', 'haystack'=>'string', 'needle'=>'string|int', 'before_needle='=>'bool'],
		'stripos' => ['int|false', 'haystack'=>'string', 'needle'=>'string|int', 'offset='=>'int'],
		'stristr' => ['string|false', 'haystack'=>'string', 'needle'=>'string|int', 'before_needle='=>'bool'],
		'strpos' => ['int|false', 'haystack'=>'string', 'needle'=>'string|int', 'offset='=>'int'],
		'strrchr' => ['string|false', 'haystack'=>'string', 'needle'=>'string|int'],
		'strripos' => ['int|false', 'haystack'=>'string', 'needle'=>'string|int', 'offset='=>'int'],
		'strrpos' => ['int|false', 'haystack'=>'string', 'needle'=>'string|int', 'offset='=>'int'],
		'strstr' => ['string|false', 'haystack'=>'string', 'needle'=>'string|int', 'before_needle='=>'bool'],
		'version_compare' => ['int|bool', 'version1'=>'string', 'version2'=>'string', 'operator='=>'string'],
		'xml_parser_create' => ['resource', 'encoding='=>'string'],
		'xml_parser_create_ns' => ['resource', 'encoding='=>'string', 'sep='=>'string'],
		'xml_parser_free' => ['bool', 'parser'=>'resource'],
		'xml_parser_get_option' => ['mixed|false', 'parser'=>'resource', 'option'=>'int'],
		'xml_parser_set_option' => ['bool', 'parser'=>'resource', 'option'=>'int', 'value'=>'mixed'],
		'xmlwriter_end_attribute' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_end_cdata' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_end_comment' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_end_document' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_end_dtd' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_end_dtd_attlist' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_end_dtd_element' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_end_dtd_entity' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_end_element' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_end_pi' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_flush' => ['mixed', 'xmlwriter'=>'resource', 'empty='=>'bool'],
		'xmlwriter_full_end_element' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_open_memory' => ['resource'],
		'xmlwriter_open_uri' => ['resource', 'source'=>'string'],
		'xmlwriter_output_memory' => ['string', 'xmlwriter'=>'resource', 'flush='=>'bool'],
		'xmlwriter_set_indent' => ['bool', 'xmlwriter'=>'resource', 'indent'=>'bool'],
		'xmlwriter_set_indent_string' => ['bool', 'xmlwriter'=>'resource', 'indentstring'=>'string'],
		'xmlwriter_start_attribute' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string'],
		'xmlwriter_start_attribute_ns' => ['bool', 'xmlwriter'=>'resource', 'prefix'=>'string', 'name'=>'string', 'uri'=>'string'],
		'xmlwriter_start_cdata' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_start_comment' => ['bool', 'xmlwriter'=>'resource'],
		'xmlwriter_start_document' => ['bool', 'xmlwriter'=>'resource', 'version='=>'string', 'encoding='=>'string', 'standalone='=>'string'],
		'xmlwriter_start_dtd' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string', 'publicid='=>'string', 'sysid='=>'string'],
		'xmlwriter_start_dtd_attlist' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string'],
		'xmlwriter_start_dtd_element' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string'],
		'xmlwriter_start_dtd_entity' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string', 'isparam'=>'bool'],
		'xmlwriter_start_element' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string'],
		'xmlwriter_start_element_ns' => ['bool', 'xmlwriter'=>'resource', 'prefix'=>'string', 'name'=>'string', 'uri'=>'string'],
		'xmlwriter_start_pi' => ['bool', 'xmlwriter'=>'resource', 'target'=>'string'],
		'xmlwriter_text' => ['bool', 'xmlwriter'=>'resource', 'content'=>'string'],
		'xmlwriter_write_attribute' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string', 'content'=>'string'],
		'xmlwriter_write_attribute_ns' => ['bool', 'xmlwriter'=>'resource', 'prefix'=>'string', 'name'=>'string', 'uri'=>'string', 'content'=>'string'],
		'xmlwriter_write_cdata' => ['bool', 'xmlwriter'=>'resource', 'content'=>'string'],
		'xmlwriter_write_comment' => ['bool', 'xmlwriter'=>'resource', 'content'=>'string'],
		'xmlwriter_write_dtd' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string', 'publicid='=>'string', 'sysid='=>'string', 'subset='=>'string'],
		'xmlwriter_write_dtd_attlist' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string', 'content'=>'string'],
		'xmlwriter_write_dtd_element' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string', 'content'=>'string'],
		'xmlwriter_write_dtd_entity' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string', 'content'=>'string', 'pe'=>'bool', 'publicid'=>'string', 'sysid'=>'string', 'ndataid'=>'string'],
		'xmlwriter_write_element' => ['bool', 'xmlwriter'=>'resource', 'name'=>'string', 'content'=>'string'],
		'xmlwriter_write_element_ns' => ['bool', 'xmlwriter'=>'resource', 'prefix'=>'string', 'name'=>'string', 'uri'=>'string', 'content'=>'string'],
		'xmlwriter_write_pi' => ['bool', 'xmlwriter'=>'resource', 'target'=>'string', 'content'=>'string'],
		'xmlwriter_write_raw' => ['bool', 'xmlwriter'=>'resource', 'content'=>'string'],
	]
];
