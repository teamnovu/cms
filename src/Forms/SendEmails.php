<?php

namespace Statamic\Forms;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Statamic\Contracts\Forms\Submission;
use Statamic\Sites\Site;

class SendEmails
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $submission;
    protected $site;

    public function __construct(Submission $submission, Site $site)
    {
        $this->submission = $submission;
        $this->site = $site;
    }

    public function handle()
    {
        $this->emailConfigs($this->submission)->each(function ($config) {
            config('statamic.forms.send_mail_job')::dispatch($this->submission, $this->site, $config);
        });
    }

    private function emailConfigs($submission)
    {
        $config = $submission->form()->email();

        $config = isset($config['to']) ? [$config] : $config;

        return collect($config);
    }
}
