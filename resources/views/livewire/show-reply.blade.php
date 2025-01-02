<div>
    <div class="rounded-md bg-gradient-to-r from-slate-800 to-slate-900 hover:to-slate-800 mb-2">
        <div class="p-4 flex gap-4">
            <div>
                <img src="{{ $reply->user->avatar() }}" alt="{{ $reply->user->name }}" class="rounded-md">
            </div>
            <div class="w-full space-y-4">
                <p class="text-blue-600 font-semibold text-xs mb-2">
                    {{ $reply->user->name }}
                </p>
                @if($is_creating || $is_editing)
                <form wire:submit.prevent="{{ $is_creating ? 'postChild' : 'updateReply' }}" class="mt-4">
                    <input
                        type="text"
                        placeholder="{{ $is_creating ? 'Escribe una respuesta (creando)' : 'Escribe una respuesta (editando)' }}"
                        class="bg-slate-800 border-1 border-slate-900 rounded-md w-full p-3 text-white/60 text-xs"
                        wire:model="body"
                    >
                </form>
                @else
                <p class="text-white/60 text-xs">
                    {{ $reply->body }}
                </p>
                @endif
                <p class="mt-4 text-white/60 text-xs flex gap-2 justify-end">
                    @if(is_null($reply->reply_id))
                        <a href="#" wire:click.prevent="createReply" class="hover:text-white">Responder</a>
                    @endif
                    @can('update', $reply)
                        <a href="#" wire:click.prevent="editReply" class="hover:text-white">Editar</a>
                    @endcan
                </p>
            </div>
        </div>
    </div>
    @foreach ($reply->replies as $item)
        <div class="ml-8">
            @livewire('show-reply', ['reply' => $item], key('reply-' . $item->id))
        </div>
    @endforeach
</div>
