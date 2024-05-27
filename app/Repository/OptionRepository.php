<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Module\Poll\Poll;
use App\Models\Module\Poll\Sub\Option;
use App\Repository\Contracts\OptionInterface;

class OptionRepository extends BaseRepository implements OptionInterface
{
    // Implement the methods
    public function create(Poll|string $poll, array $payload): void
    {
        // dd($payload['options']);
        foreach ($payload['options'] as $optionValue) {
            Option::create([
                'poll_id' => $poll->id,
                'title' => $optionValue['title'],
            ]);
        }
    }
    public function update(Poll|string $poll, array $payload): void
    {
        $existingOptions = Option::where('poll_id', $poll->id)->get();

        // Convert to a key-value pair array for easy lookup
        $existingOptionsMap = $existingOptions->keyBy('id')->toArray();

        // Process each option data from the payload
        foreach ($payload['options'] as $potentialOption) {
            // dd($potentialOption['title'], isset($existingOptionsMap[$potentialOption['title']]));
            if (isset($existingOptionsMap[$potentialOption['id']])) {
                // If the title ID exists, update other details if needed
                // For example, update something or just touch it to update timestamps
                $option = Option::find($potentialOption['id']);
                $option->title = $potentialOption['title'];
                $option->save();
                // Remove from the existing list to track which are still in use
                unset($existingOptionsMap[$potentialOption['id']]);
                // dd($potentialOption['id'], $existingOptionsMap);
            } else {
                // If the title ID does not exist, create a new option
                $option = new Option();
                $option->poll_id = $poll->id;
                $option->title = $potentialOption['title'];
                $option->save();
            }
        };
        // dd($existingOptionsMap);
        // Any remaining items in $existingOptionsMap are not in the new payload and should be considered for deletion
        foreach ($existingOptionsMap as $existingOption) {
            // Optionally delete or deactivate unused options
            Option::where('poll_id', $poll->id)
                ->where('title', $existingOption['title'])
                ->forceDelete();  // Or another action as needed
        }
    }
}
