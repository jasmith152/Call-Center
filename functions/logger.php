<?php
class Logging
{
  protected $logger_id;
  private $log_file = '/xampp/logger/logfile';
  private $fp = null;
  public function __construct()
  {
    //add an id (not truly unique if 2 users hit the site at the same milisecond, but close enought to sort on path and id in excel)
    $this->logger_id = uniqid().'-'.$_SESSION['write_user'];
  }
  public function lfile($path)
  {
    $this->log_file = $path;
  }
  public function lwrite($message)
  {
    if (!$this->fp) $this->lopen();
    $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
    $time = date('g:i:s A');
    fwrite($this->fp, $this->logger_id.",".$time.",".$message.PHP_EOL);
  }
  private function lopen()
  {
    $lfile = $this->log_file;
    $today = date('Y-m-d');
    $this->fp = fopen($lfile . '_' . $today.'.log', 'a') or exit("Can't open $lfile!");
  }
}
?>
