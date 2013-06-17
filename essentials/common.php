<?PHP

function redirect($url = '') {
	if (!preg_match('#^https?://#i', $url)) {
            $url = "http://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]?page=".($url == '' ? 'index': $url);
        }
        header("Location: ".$url, TRUE);
        die();
}