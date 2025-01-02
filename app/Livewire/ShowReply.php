<?php

namespace App\Livewire;

use App\Models\Reply;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ShowReply extends Component
{
    use AuthorizesRequests;
    public Reply $reply;
    public $body = '';
    public $is_creating = false;
    public $is_editing = false;

    // protected $listeners = ['refresh' => '$refresh']; Esto ya no es necesario después de Livewire 3.0
    public function editReply()
    {
        $this->authorize('update', $this->reply);
        $this->is_editing = !$this->is_editing;
        $this->is_creating = false;
        $this->body = $this->reply->body;
    }

    public function createReply()
    {
        $this->is_creating = !$this->is_creating;
        $this->is_editing = false;
        $this->body = '';
    }

    public function resetState()
    {
        $this->is_creating = false;
        $this->is_editing = false;
        $this->body = '';
    }

    public function updateReply()
    {
        $this->authorize('update', $this->reply);
        // validate
        $this->validate(['body' => 'required']);

        // update
        $this->reply->update(['body' => $this->body]);

        // refresh
        $this->resetState();
    }

    public function postChild()
    {
        if (!is_null($this->reply->reply_id)) return;
        // validate
        $this->validate(['body' => 'required']);

        // create
        auth()->user()->replies()->create([
            'reply_id' => $this->reply->id,
            'thread_id' => $this->reply->thread->id,
            'body' => $this->body,
        ]);

        // refresh
        $this->resetState();
        // $this->emitSelf('refresh'); Esto ya no es necesario después de Livewire 3.0
    }

    public function render()
    {
        return view('livewire.show-reply');
    }
}
