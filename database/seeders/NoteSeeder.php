<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $noteTemplates = [
            ['title' => 'Morning Coffee Routine', 'content' => 'Start the day with a perfect cup of coffee. Grind beans fresh, use filtered water at 200°F...', 'is_pinned' => true, 'is_published' => true],
            ['title' => 'Weekend Hiking Plans', 'content' => 'Planning a weekend hike to the local trails. Need to check weather forecast and pack essentials...', 'is_pinned' => false, 'is_published' => false],
            ['title' => 'Book Recommendations', 'content' => 'Great books I read this month: "The Seven Habits" and "Atomic Habits" changed my perspective...', 'is_pinned' => true, 'is_published' => true],
            ['title' => 'Home Garden Progress', 'content' => 'Tomatoes are growing well this season. Need to add more fertilizer and check for pests...', 'is_pinned' => false, 'is_published' => false],
            ['title' => 'Weekly Meal Prep', 'content' => 'Preparing meals for the week ahead. Chicken, rice, and vegetables make a balanced combo...', 'is_pinned' => true, 'is_published' => true],
            ['title' => 'Exercise Routine', 'content' => 'Monday: Cardio, Tuesday: Strength training, Wednesday: Yoga. Keeping consistency is key...', 'is_pinned' => false, 'is_published' => false],
            ['title' => 'Travel Ideas', 'content' => 'Planning next vacation. Considering mountains vs beach. Need to compare costs and activities...', 'is_pinned' => false, 'is_published' => true],
            ['title' => 'Work Project Notes', 'content' => 'Important deadlines coming up. Team meeting scheduled for Thursday to discuss progress...', 'is_pinned' => true, 'is_published' => false],
            ['title' => 'Photography Tips', 'content' => 'Better photos with natural lighting. Golden hour provides the most flattering light for portraits...', 'is_pinned' => false, 'is_published' => true],
            ['title' => 'Budget Planning', 'content' => 'Monthly expenses review. Need to cut down on dining out and allocate more for savings...', 'is_pinned' => false, 'is_published' => false],
            ['title' => 'Weekend DIY Project', 'content' => 'Building a bookshelf for the living room. Measured the space, now need to buy materials...', 'is_pinned' => true, 'is_published' => true],
            ['title' => 'Learning Spanish', 'content' => 'Daily practice with language apps. Focus on conversational phrases and basic grammar rules...', 'is_pinned' => false, 'is_published' => false],
            ['title' => 'Movie Night Ideas', 'content' => 'Great films to watch this weekend. Classic comedies and recent documentaries on the list...', 'is_pinned' => false, 'is_published' => true],
            ['title' => 'Car Maintenance', 'content' => 'Oil change due next week. Also need to check tire pressure and schedule brake inspection...', 'is_pinned' => false, 'is_published' => false],
            ['title' => 'Birthday Party Planning', 'content' => 'Organizing surprise party for friend. Guest list ready, need to book venue and order cake...', 'is_pinned' => true, 'is_published' => true]
        ];

        foreach ($noteTemplates as $index => $noteData) {
            $user = $users->random();
            $slug = $noteData['is_published'] ? Str::slug($noteData['title']) : null;

            Note::create([
                'user_id' => $user->id,
                'is_published' => $noteData['is_published'],
                'data' => [
                    'title' => $noteData['title'],
                    'content' => $noteData['content'],
                    'slug' => $slug,
                    'is_pinned' => $noteData['is_pinned'],
                    'image_path' => null
                ]
            ]);
        }
    }
}