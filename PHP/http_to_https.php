/**
 * Edit in file: .htaccess
 */

RewriteCond %{HTTPS} off
RewriteRule (.*) https://%{SERVER_NAME}/$1 [R,L]