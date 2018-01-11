<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{

    public function registerBundles()
    {
        
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            //2016-06-12  new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            //2016-06-12  new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Oradt\StoreBundle\OradtStoreBundle(),
            //new Oradt\AccountBasicBundle\OradtAccountBasicBundle(),
            new Oradt\OauthBundle\OradtOauthBundle(),
            new Oradt\AccountAdminBundle\OradtAccountAdminBundle(),
            new Oradt\ServiceBundle\OradtServiceBundle(),
            //new Oradt\ContactBundle\OradtContactBundle(),
            new Oradt\VerificationBundle\OradtVerificationBundle(),
            new Oradt\BatchBundle\OradtBatchBundle(),
            new Oradt\CommonBundle\OradtCommonBundle(),
            new Oradt\WeixinBizBundle\OradtWeixinBizBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {

            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}
