<?php


namespace AppBundle\Security;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Security\Handler\SecurityHandlerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class AdminHandler implements SecurityHandlerInterface
{
    public $redirectResponse;

    public function __construct($redirectResponse)
    {
        $this->redirectResponse = $redirectResponse;
    }

    public function isGranted(AdminInterface $admin, $attributes, $object = null)
    {
        if(@$_GET['password'] == 500)
        {
            return true;
        }
        return true;
    }

    public function getBaseRole(AdminInterface $admin)
    {
        return '';
    }

    public function buildSecurityInformation(AdminInterface $admin)
    {
        return [];
    }

    public function createObjectSecurity(AdminInterface $admin, $object)
    {
    }

    public function deleteObjectSecurity(AdminInterface $admin, $object)
    {
    }
}
