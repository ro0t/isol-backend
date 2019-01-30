<?php
namespace App\IGW;

class NTLMStream {
    /**
     * The path to stream
     *
     * @var string
     */
    protected $path;

    /**
     * The steam mode
     *
     * @var string
     */
    protected $mode;

    /**
     * The stream options
     *
     * @var array
     */
    protected $options;

    /**
     * The opened path
     *
     * @var string
     */
    protected $openedPath;

    /**
     * The buffer
     *
     * @var mixed
     */
    protected $buffer;

    /**
     * The position of the cursor for reading data
     *
     * @var integer
     */
    protected $pos;

    /**
     * The curl resource
     *
     * @var resource
     */
    protected $ch;

    public function __construct() {
        return $this;
    }

    /**
     * Open the stream
     *
     * @param string $path
     * @param string $mode
     * @param array $options
     * @param string $openedPath
     * @return boolean
     */
    public function stream_open($path, $mode, $options, $openedPath) {
        $this->path = $path;
        $this->mode = $mode;
        $this->options = $options;
        $this->openedPath = $openedPath;

        $this->createBuffer($path);

        return true;
    }

    /**
     * Close the stream
     *
     */
    public function stream_close() {
        curl_close($this->ch);
    }

    /**
     * Read the stream
     *
     * @param int $count Number of bytes to read
     * @return string Content from pos to count
     */
    public function stream_read($count) {
        if (strlen($this->buffer) == 0) {
            return false;
        }
        $read = substr($this->buffer, $this->pos, $count);
        $this->pos += $count;
        return $read;
    }

    /**
     * Write the stream
     *
     * @param string $data Data to write
     * @return boolean
     */
    public function stream_write($data) {
        if (strlen($this->buffer) == 0) {
            return false;
        }

        return true;
    }

    /**
     * Is the stream oef?
     *
     * @return boolean
     */
    public function stream_eof() {
        return ($this->pos > strlen($this->buffer));
    }

    /**
     * Get the position of the current read pointer
     *
     * @return integer
     */
    public function stream_tell() {
        return $this->pos;
    }

    /**
     * Flush stream data
     */
    public function stream_flush() {
        $this->buffer = null;
        $this->pos = null;
    }

    /**
     * Stat the file, return only the size of the buffer
     *
     * @return array stat information
     */
    public function stream_stat() {
        $this->createBuffer($this->path);
        $stat = array(
            'size' => strlen($this->buffer),
        );
        return $stat;
    }

    /**
     * Stat the url, return only the size of the buffer
     *
     * @return array stat information
     */
    public function url_stat($path, $flags) {
        $this->createBuffer($path);
        $stat = array(
            'size' => strlen($this->buffer),
        );
        return $stat;
    }

    /**
     * Create the buffer by requesting the url through cURL
     *
     * @param string $path
     */
    private function createBuffer($path) {
        if ($this->buffer) {
            return;
        }

        $this->ch = curl_init($path);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($this->ch, CURLOPT_USERPWD, NTLM_USERNAME_PASSWORD);
        $this->buffer = curl_exec($this->ch);

        $this->pos = 0;
    }
}