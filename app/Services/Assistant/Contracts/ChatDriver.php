<?php

namespace App\Services\Assistant\Contracts;

use App\Models\AssistantProvider;
use App\Services\Assistant\Data\AnswerResult;
use App\Services\Assistant\Data\PromptBundle;

interface ChatDriver
{
    public function __construct(AssistantProvider $provider);

    /**
     * Send the grounded prompt and return a structured answer.
     *
     * Implementations throw on transport or credential failure so ProviderManager
     * can fall through to the next provider by priority.
     */
    public function answer(PromptBundle $prompt): AnswerResult;

    /** Cheap round-trip used by the Test connection button in the admin panel. */
    public function ping(): bool;
}
