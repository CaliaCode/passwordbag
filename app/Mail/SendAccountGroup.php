<?php

namespace App\Mail;

use App\Models\AccountGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAccountGroup extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Account Group instance.
     *
     * @var AccountGroup
     */
    protected $accountGroup;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\AccountGroup $accountGroup
     */
    public function __construct(AccountGroup $accountGroup)
    {
        $this->accountGroup = $accountGroup;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@caliacode.com')
                    ->subject('Your Accounts')
                    ->view('emails.send-account-group')
                    ->with(['accountGroup' => $this->accountGroup]);
    }
}
