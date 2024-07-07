<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Attributes\Rule as LivewireRule;
use Illuminate\Validation\Rule;
use App\Models\Post;
use Livewire\Form;

class PostForm extends Form
{
    #[LivewireRule('required|min:3')]
    public $title;

    #[LivewireRule('required|min:3')]
    public $body;

    public $postId;

    public function rules()
    {
        return [
            'title' => [
                'required',
                'min:3',
                Rule::unique('posts')->ignore($this->postId),
            ],
            'body' => 'required|min:3',
        ];
    }
 
    public function save()
    {
        $this->validate($this->rules());
        Post::create([
            'title' => $this->title,
            'body' => $this->body,
        ]);
        $this->reset('form.title','form.body');
    }

    public function change()
    {
        $this->validate($this->rules());

        $post = Post::find($this->postId);        
        if ($post) {
            $post->update([
                'title' => $this->title,
                'body' => $this->body,
            ]);
            $this->reset('form.title','form.body');
        }
        
    }
}
