<?php

namespace Oradt\CronBundle\Core;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils\BaseTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
//use Symfony\Component\Routing\RequestContext;
use Oradt\Utils\RandomString;
use Symfony\Component\HttpFoundation\ParameterBag;
abstract class Cron
{
    use BaseTrait;
    protected $logger = null;
	private $jobs = array();
	/**
	 * kernel container
	 * @var Core container
	 */
	protected $container;
	public function __construct(ContainerInterface $container)
	{
	    $this->container = $container;
		$this->addJob('run', $this->getRunInterval());
		$this->setLoggerName('cron.log');
			
	}
	
	/**
	 * 设置日志文件
	 * @param string $fileName
	 * @param string $logDir
	 */
	public function setLoggerName($fileName , $logDir = null) {
	    if(empty($logDir)) {
	        $logDir = $this->container->getParameter('kernel.logs_dir');
	    }
	    $stream = new StreamHandler( $logDir . DIRECTORY_SEPARATOR . $fileName);
	    $this->logger = new Logger("cron_logger",array($stream));
	}

	/**
	 * Add a cron job
	 * @param string $jobName
	 * @param int $runInterval in minutes
	 */
	
	protected function addJob($jobName, $runInterval)
	{
		$this->jobs[$jobName] = $runInterval;
	}
	
	public function getJobList()
	{
		return $this->jobs;
	}
	
	/**
	 * Return run interval in minutes
	 * @return int
	 */
	public function getRunInterval()
	{
		return 1;
	}
	
	public abstract function run();
	
	/**
	 * user login 
	 * @param string $user
	 * @param string $passwd
	 * @param string $type
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function login($user,$passwd,$type='basic') {
	    $path['_controller'] = 'Oradt\\OauthBundle\\Controller\\OauthController::postAction';
	    $postparam = array('user'=>$user,'passwd' => $passwd , 'type' => $type , 'ip' => '1.1');
	    $request = new Request(array(),$postparam,$path,array(),array(),array(),null);
	    $result = $this->container->get('http_kernel')->handle($request, HttpKernelInterface::SUB_REQUEST);
	    return $result;
	}
	
	public function doController($path,$token = '',array $query = array(),
	        array $postparam = array(),array $files = array()) {
	    $servers = array();
	    if(!empty($token))
	        $servers = array('HTTP_accesstoken' =>$token);
	    
	    //$path = $this->getCurrentController($apiurl,strtoupper($method));
	    $request = new Request($query,$postparam,$path,array(),array(),$servers,null);
	    if(!empty($files))
	       $request->files = new ParameterBag($files);
	    
	    return $this->container->get('http_kernel')->handle($request, HttpKernelInterface::SUB_REQUEST);
	}
	
	public function sendMail($toMail,$subject,$body) {
	    require_once dirname(dirname(dirname(__FILE__))) . '/Utils/PHPMailer/PHPMailerAutoload.php';
            $mail = new \PHPMailer;
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->container->getParameter('mailer_host');  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->container->getParameter('mailer_user');                 // SMTP username
            $mail->Password = $this->container->getParameter('mailer_password');                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            //$mail->Port = 587;                                    // TCP port to connect to
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($this->container->getParameter('mailer_user'), '系统管理员');
            $mail->addAddress($toMail, '');     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $subject;
            $mail->Body    = $body;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
                return false;
                //echo 'Message could not be sent.';
                //echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                return true;
                //echo 'Message has been sent';
            }
            
            /*$message = \Swift_Message::newInstance()
	    ->setSubject($subject)
	    ->setFrom($this->container->getParameter("mailer_user"))
	    ->setTo($toMail)
	    ->setBody( $body );
	     $this->container->get('mailer')->send($message);*/
	}
    
    public function moveFile($sourceFile,$targetFile) {
        if(is_file($sourceFile)) {
            copy($sourceFile, $targetFile);
            unlink($sourceFile);
        }
    }
    
    public function mkdir($path,$name) {
        $bakdir = $path . $name  . DIRECTORY_SEPARATOR;
        if(!is_dir($bakdir))
            mkdir($bakdir);
        return $bakdir;
    }
    public function removeDirectory($dir) {
        if(strpos(php_uname('s'),'Linux')!==false) {
            $command = "rm -Rf ".$dir;
            system($command);
        }
    }

    public function clearLogin($token) {
        $sql = "DELETE FROM login_session WHERE session_id=:sessionid";
        $this->getConnection()->executeUpdate($sql, array(':sessionid' => $token));
    }

    public function insertSession($accountId,$accountType = 'basic') {
        //
        $token = 'Cron_' .RandomString::make(35) ;
        $login_sql = "INSERT INTO login_session (session_id,account_id,account_type,created_time) VALUES (:sid,:accountid,:type,:date)";
        $params = array(':sid' => $token,
                ':accountid' => $accountId,
                ':type' => $accountType,
                ':date' => '2018-01-01'
        );
        $this->getConnection()->executeQuery($login_sql,$params);
        return $token;
    }

    public function getControllerResult(\Symfony\Component\HttpFoundation\Response $response) {
        return json_decode ( $response->getContent (), true );
    }
}