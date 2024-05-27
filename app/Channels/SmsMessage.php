<?php

declare(strict_types=1);

namespace App\Channels;

use App\Jobs\SmsJob;
use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;

class SmsMessage
{
    use DispatchesJobs;

    protected string $user;
    protected string $password;
    protected string $to;
    protected string $from;
    protected array $lines;
    protected bool $dryrun = false;

    /**
     * SmsMessage constructor.
     */
    public function __construct(array $lines = [])
    {
        $this->lines = $lines;
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    public function send(): void
    {
        if (!$this->to || !count($this->lines)) {
            throw new Exception('SMS not correctly set up.');
        }
        if (app()->environment() !== 'local' && app()->environment() !== 'testing') {
            //            if (!$this->dryrun) {
            SmsJob::dispatch(text: Arr::join($this->lines, '\n'), phone: $this->to);
            //                dispatch(new SmsJob(Arr::join($this->lines, '\n'), $this->to));
            //            }
        }
    }

    public function dryRun($dry = true): self
    {
        $this->dryrun = $dry;

        return $this;
    }
}
