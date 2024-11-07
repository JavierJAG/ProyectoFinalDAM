<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'javier.araujo@teconsite.com'; // Dirección de correo de origen
    public string $fromName   = 'PescadoresDaRia';              // Nombre del remitente
    public string $recipients = '';                             // Destinatarios predeterminados (si es necesario)

    /**
     * The "user agent"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol: mail, sendmail, smtp
     */
    public string $protocol = 'smtp';  // Usamos SMTP para enviar correos

    /**
     * SMTP Server Hostname
     */
    public string $SMTPHost = 'teconsite.com';  // Servidor SMTP de destino

    /**
     * SMTP Username
     */
    public string $SMTPUser = 'javier.araujo@teconsite.com';  // Nombre de usuario SMTP (el correo electrónico)

    /**
     * SMTP Password
     */
    public string $SMTPPass = 'IGF]9*CW[_$4';  // La contraseña de tu cuenta de correo

    /**
     * SMTP Port
     */
    public int $SMTPPort = 465;  // Puerto SMTP para conexiones seguras SSL

    /**
     * SMTP Timeout (in seconds)
     */
    public int $SMTPTimeout = 5;

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption.
     *
     * @var string '', 'tls' or 'ssl'. 'tls' will issue a STARTTLS command
     *             to the server. 'ssl' means implicit SSL. Connection on port
     *             465 should set this to 'ssl'.
     */
    public string $SMTPCrypto = 'ssl';  // Usamos SSL para la conexión segura

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true;

    /**
     * Character count to wrap at
     */
    public int $wrapChars = 76;

    /**
     * Type of mail, either 'text' or 'html'
     */
    public string $mailType = 'text';

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public string $charset = 'UTF-8';

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
