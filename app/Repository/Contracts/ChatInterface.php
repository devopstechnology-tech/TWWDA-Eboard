<?php

namespace App\Repository\Contracts;

use App\Models\Module\Discussions\Discussion;
use App\Models\User;
use App\Models\Module\Member\Member;
use App\Models\Module\Discussions\Sub\Chat;
use App\Models\Module\Discussions\Sub\DiscussionAssignee;

interface ChatInterface
{
    // Define your methods here
    public function createChat($user, array $payload);
    public function updateChat(Chat $chat, array $payload);
    public function delete(Discussion $discussion);

}
