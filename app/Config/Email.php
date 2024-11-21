<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'pescadoresDaRia@gmail.com'; // Dirección de correo de origen (tu cuenta de Gmail)
    public string $fromName   = 'PescadoresDaRia';           // Nombre del remitente
    public string $recipients = '';                          // Destinatarios predeterminados (opcional)

    /**
     * The "user agent"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol: SMTP
     */
    public string $protocol = 'smtp';  // Protocolo SMTP

    /**
     * SMTP Server Hostname
     */
    public string $SMTPHost = 'smtp.gmail.com'; // Servidor SMTP de Gmail

    /**
     * SMTP Port
     */
    public int $SMTPPort = 587;  // Puerto 587 para STARTTLS

    /**
     * SMTP Encryption
     * STARTTLS es necesario para Gmail
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Username
     * Utiliza tu dirección de correo como nombre de usuario
     */
    public string $SMTPUser = 'pescadoresDaRia@gmail.com'; // Dirección de correo completa

    /**
     * SMTP Password
     * Usar la contraseña de aplicación generada en la configuración de seguridad de tu cuenta de Gmail.
     * Ve a https://myaccount.google.com/apppasswords para generarla.
     */
    public string $SMTPPass = 'qgle zgjz bqkv mjdq '; // Contraseña de aplicación

    /**
     * SMTP Timeout (in seconds)
     * Ajusta según tus necesidades; el valor predeterminado de 10 es razonable.
     */
    public int $SMTPTimeout = 10;

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true;

    /**
     * Character count to wrap at
     */
    public int $wrapChars = 76;

    /**
     * Type of mail
     * Puede ser 'html' o 'text'; normalmente se utiliza 'html'.
     */
    public string $mailType = 'html';

    /**
     * Character set
     * UTF-8 es el estándar recomendado.
     */
    public string $charset = 'UTF-8';

    /**
     * Validate email addresses
     */
    public bool $validate = true;

    /**
     * Email Priority
     * 1 = más alta, 5 = más baja, 3 = normal
     */
    public int $priority = 3;

    /**
     * Newline character
     * Usa "\r\n" para cumplir con el estándar RFC 822.
     */
    public string $CRLF = "\r\n";

    /**
     * Newline character
     * Usa "\r\n" para cumplir con el estándar RFC 822.
     */
    public string $newline = "\r\n";

    /**
     * Enable notify message from server
     */
    public bool $DSN = false;
}
