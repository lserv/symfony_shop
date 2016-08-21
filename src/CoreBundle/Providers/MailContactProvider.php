<?php

namespace Shop\CoreBundle\Providers;

class MailContactProvider
{
    private $contactFrom;
    private $contactEmail;
    private $mailProvider;
    
    public function __construct($contactEmail, $contactFrom)
    {
        $this->contactEmail = $contactEmail;
        $this->contactFrom = $contactFrom;
    }
    
    public function setMailerProvider(MailProvider $mailProvider)
    {
        $this->mailProvider = $mailProvider;
    }
    
    public function sendEmail($data)
    {
        $body = $this->mailProvider->renderView('CoreBundle:Mail:contact.html.twig', ['data' => $data]);
        return $this
            ->mailProvider
            ->sendEmail('Contact from shop', $this->contactFrom, $this->contactEmail, $body);
    }
}
