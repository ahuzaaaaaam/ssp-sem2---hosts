<div>
    {{-- This component logs user login activities --}}
    @if(auth()->check())
        {{-- User is logged in, we can log activities --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Dispatch the login event to the Livewire component
                Livewire.dispatch('user-logged-in');
            });
        </script>
    @endif
    
    {{-- Listen for login events --}}
    <div wire:init="logUserActivity"></div>
</div>
