<?php

namespace Shop\CoreBundle\Providers;

class MailProvider
{
    private $container;
    
    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function renderView($view, array $parameters = [])
    {
        if ($this->container->has('templating')) {
            return $this->container
                ->get('templating')
                ->render($view, $parameters);
        }

        if (!$this->container->has('twig')) {
            throw new \LogicException('You can not use the "renderView" method if the Templating Component or the Twig Bundle are not available.');
        }

        return $this->container
            ->get('twig')
            ->render($view, $parameters);
    }

    public function sendEmail($subject, $from, $to, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body);

        return $this->container
            ->get('mailer')
            ->send($message);
    }
}
