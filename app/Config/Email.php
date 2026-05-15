<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
            //  Konstruktor: Werte aus .env laden ──
    public function __construct()
    {
        parent::__construct();

        // env() liest aus der .env-Datei; zweiter Parameter ist der Fallback
        $this->SMTPHost   = env('EMAIL_HOST',      'localhost'); //„Lies den Wert EMAIL_HOST aus der .env Datei. Wenn er nicht existiert → nimm 'localhost'“
        $this->SMTPPort   = (int) env('EMAIL_PORT', ''); //469 (aus Outlook) oder 465???
        $this->SMTPUser   = env('EMAIL_USERNAME',   '');
        $this->SMTPPass   = env('EMAIL_PASSWORD',   '');
        $this->fromEmail  = env('EMAIL_FROM_ADDR',  '');
        $this->fromName   = env('EMAIL_FROM_NAME',  'Webseite');
    }


    // Werte kommen aus .env, Fallback-Werte stehen hier
    public string $fromEmail  = '';
    public string $fromName   = '';
    public string $recipients = '';

    /**
     * The "user agent"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol: mail, sendmail, smtp
     */
    // 'smtp' ist für Produktionssysteme Pflicht (anstelle von 'mail' oder 'sendmail')
    public string $protocol = 'smtp';

    /**
     * The server path to Sendmail.
     */
    public string $mailPath = '/usr/sbin/sendmail';


    // SMTP-Verbindung
    // SMTPCrypto: 'tls' für Port 587 (STARTTLS), 'ssl' für Port 465 (SMTPS)
    // → STARTTLS (Port 587) ist der moderne Standard

    /**
     * SMTP Server Hostname
     */
    public string $SMTPHost = '';

    /**
     * Which SMTP authentication method to use: login, plain
     */
    public string $SMTPAuthMethod = 'login';

    /**
     * SMTP Username
     */
    public string $SMTPUser = '';

    /**
     * SMTP Password
     */
    public string $SMTPPass = '';

    /**
     * SMTP Port
     */
    public int $SMTPPort = 2525;

    /**
     * SMTP Timeout (in seconds)
     */
    public int $SMTPTimeout = 10; // Sekunden bis Timeout

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption.
     *
     * @var string '', 'tls' or 'ssl'. 'tls' will issue a STARTTLS command
     *             to the server. 'ssl' means implicit SSL. Connection on port
     *             465 should set this to ''.
     */
    // public string $SMTPCrypto = 'tls'; // TLS = STARTTLS auf Port 587
    // Port 465 = implizites SSL → SMTPCrypto leer lassen
    // public string $SMTPCrypto = ''; // TLS = STARTTLS auf Port 587
    public string $SMTPCrypto = 'tls'; // TLS = STARTTLS auf Port 587

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true; // RFC 822: Zeilen nach 76 Zeichen umbrechen

    /**
     * Character count to wrap at
     */
    public int $wrapChars = 76;


    // Format & Darstellung 
    /**
     * Type of mail, either 'text' or 'html'
     */
    public string $mailType = 'html'; // 'html' oder 'text'

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public string $charset = 'UTF-8'; // Pflicht für deutschen Zeichensatz (ä, ö, ü)

    /**
     * Whether to validate the email address
     */
    public bool $validate = false;

    /**
     * Email Priority. 1 = highest. 5 = lowest. 3 = normal
     */
    public int $priority = 3;

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $CRLF = "\r\n";

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $newline = "\r\n";

    /**
     * Enable BCC Batch Mode.
     */
    public bool $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable notify message from server
     */
    public bool $DSN = false;






}
