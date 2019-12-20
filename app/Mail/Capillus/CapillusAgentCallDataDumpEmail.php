<?php

namespace App\Mail\Capillus;

class CapillusAgentCallDataDumpEmail extends CapillusMailBase
{    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('yjorge@eccocorpbpo.com', 'Yisme Jorge')
            ->bcc('yjorge@eccocorpbpo.com')
            ->view('emails.capillus')
            ->attachFromStorage($this->capillus_file_name)
            ->subject("Kipany-Capillus – Agent Call Data Dump");
    }
}
