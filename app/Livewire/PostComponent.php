<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

use App\Models\Post;
use App\Livewire\Forms\PostForm;

class PostComponent extends Component
{
    use WithPagination;

    public $isOpen = 0;
    public $postId;
    public PostForm $form;
 
    public function create()
   {
       $this->reset('form.title','form.body', 'postId');
       $this->openModal();
   }

    public function openModal()
    {        
        $this->isOpen = true;
        $this->resetValidation();
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.post-component',[
            'posts' => Post::paginate(5),
        ]);
    }

    public function store()
    {
        $this->form->postId = null;
        $this->validate();
        $this->form->save();
        session()->flash('success', 'Post created successfully.');
        $this->reset('form.title','form.body');
        $this->closeModal();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->form->title = $post->title;
        $this->form->body = $post->body;
        $this->form->postId = $id;
        $this->openModal();
    }

    public function update()
    {
        $this->form->postId = $this->postId;
        $this->validate();
        $this->form->change();
        $this->postId = '';
        session()->flash('success', 'Post updated successfully.');
        $this->closeModal();
    }

    public function delete($id)
  {
      Post::find($id)->delete();
      session()->flash('success', 'Post deleted successfully.');
      $this->reset('form.title','form.body');
  }
}
