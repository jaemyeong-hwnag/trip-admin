<?php
    /**
     * @see AES256 암호화
     * @param array $text - 암호화 이전 평문 문자열
     * @return array $encrypted - 암호화된 문자열
     */
    function getAesEncrypt($text)
    {
        $encryption_key = env("encryption.key", null);
        $encryption_iv = str_repeat(chr(0), 16);
        $encryption_way = env("encryption.way", null);

        $encrypted = openssl_encrypt($text, $encryption_way, $encryption_key, true, $encryption_iv); // 평문인 암호를 암호화 하여 저장
        $encrypted = base64_encode($encrypted);

        return $encrypted;
    }

    /**
     * @see AES256 복호화
     * @param array $encrypted - 암호화된 문자열
     * @return array $text - 복호화된 문자열
     */
    function getAesDecrypt($encrypted)
    {
        $encryption_key = env("encryption.key", null);
        $encryption_iv = str_repeat(chr(0), 16);
        $encryption_way = env("encryption.way", null);

        $encrypted = base64_decode($encrypted);
        $text = openssl_decrypt($encrypted, $encryption_way, $encryption_key, true, $encryption_iv); // 복호화

        return $text;
    }

    /**
     * @see AES256 복호화 - array
     * @param array $encrypted_array - 암호화된 문자 배열
     * @return array $text_array - 복호화된 문자 배열
     */
    function getListAesDecrypt($encrypted_array)
    {
        $return = array();
        $encryption_key = env("encryption.key", null);
        $encryption_iv = str_repeat(chr(0), 16);
        $encryption_way = env("encryption.way", null);

        foreach($encrypted_array as $encrypted_row) {
            $text_array = array();
            foreach($encrypted_row as $key => $value) {
                $encrypted = base64_decode($value);
                $text_array[$key] = openssl_decrypt($encrypted, $encryption_way, $encryption_key, true, $encryption_iv); // 복호화
            }
            $return[] = $text_array;
        }

        return $return;
    }

    /**
     * @see AES256 복호화 - array
     * @param array $encrypted - 암호화된 문자열
     * @return array $text_array - 복호화된 문자열
     */
    function getInfoAesDecrypt($encrypted_array)
    {
        $return = array();
        $encryption_key = env("encryption.key", null);
        $encryption_iv = str_repeat(chr(0), 16);
        $encryption_way = env("encryption.way", null);

        foreach($encrypted_row as $key => $value) {
            $encrypted = base64_decode($value);
            $return[$key] = openssl_decrypt($encrypted, $encryption_way, $encryption_key, true, $encryption_iv); // 복호화
        }

        return $return;
    }
?>