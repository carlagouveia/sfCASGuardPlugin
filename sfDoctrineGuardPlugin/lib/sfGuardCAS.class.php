<?php
/**
 * sfGuardCAS
 * 
 * Utility class to access the phpCAS library, originally part of 
 * sfCASPlugin and ported to work with sfGuard
 * 
 * @package symfony
 * @subpackage plugin
 * @author D.Jeanmonod
 * @author Klaus Silveira <contact@klaussilveira.com>
 */
class sfGuardCAS {
	
  protected static $loaded = false;
  
  /**
   * Initialize the phpCAS librairies
   */
  public static function init(){
    // Return if already loaded
    if (self::$loaded)
      return;
                    
    // Init CAS using the config from app.yml
    require_once(dirname(__FILE__).'/vendor/phpCAS/CAS.php');
    phpCAS::client(
      CAS_VERSION_2_0, 
      sfConfig::get('app_cas_server_name'), 
      sfConfig::get('app_cas_server_port'), 
      sfConfig::get('app_cas_server_path'),
      false // Don't automatically start the session as it will be handled by the Symfony session
    );
    
    // Disable SSL validation in development mode
    if (sfConfig::get('sf_environment') == 'dev' || sfConfig::get('app_cas_server_cert') == ''){
      phpCAS::setNoCasServerValidation();
    } else {
	  phpCAS::setCasServerCACert(sfConfig::get('app_cas_server_cert'));
	}
    
    // Log CAS activity to the standard log directory in debug mode
    if (sfConfig::get('sf_debug', false) == true){
      phpCAS::setDebug(sfConfig::get('sf_log_dir').'/phpCAS_'.sfConfig::get('sf_environment').'.log');
    }
    
    self::$loaded = true;
  }
  
  
  /**
   * Return the login page url
   * @return string
   */
  public static function getLoginURL(){
    self::init();
    return phpCAS::getServerLoginURL();
  }
}
