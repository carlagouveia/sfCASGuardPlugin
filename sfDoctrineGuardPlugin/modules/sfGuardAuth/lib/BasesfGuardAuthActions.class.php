<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardAuthActions.class.php 23800 2009-11-11 23:30:50Z Kris.Wallsmith $
 */
class BasesfGuardAuthActions extends sfActions
{
  public function executeSignin($request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated()) {
      return $this->redirect('@homepage');
    }
    
    sfGuardCAS::init();
    phpCAS::forceAuthentication();
    
    $user = Doctrine::getTable('sfGuardUser')->retrieveByUsername(phpCAS::getUser());
    $this->getUser()->signin($user, true);
    
    $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer($request->getReferer()));
    
    return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
  }

  public function executeSignout($request)
  {
    $this->getUser()->signOut();
    sfGuardCAS::init();
    phpCAS::logout();
  }

  public function executeSecure($request)
  {
    $this->getResponse()->setStatusCode(403);
  }

  public function executePassword($request)
  {
    throw new sfException('This method is not yet implemented.');
  }
}
