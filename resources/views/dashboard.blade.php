<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome {{ Str::ucfirst(explode('@', Auth::user()->email)[0]) }}
        </h2>
        @vite(['resources/css/app.css'])
    </x-slot>

    <body>
        <form id="multiEntryForm" method="POST" action="/add-details" class="max-w-3xl mx-auto my-8 p-6 bg-white shadow-md rounded-md">
            @csrf
            <div id="entryContainer">
                <div class="entry-group relative p-4 mb-4 border border-gray-800 rounded-md">
                    <!-- Cancel button at the top right -->
                    <button type="button" onclick="removeEntry(this)" class="cancel-button text-red-500 font-semibold text-xl">&times;</button>
                    
                    <h3 class="text-lg font-semibold mb-2">Entry</h3>

                    <label class="block mb-2">Email Address</label>
                    <input type="text" 
                           name="emailAddress[]" 
                           required class="w-full p-2 mb-3 border border-gray-300 rounded-md"
                           value="{{ Auth::user()->email }}" readonly>

                    <label class="block mb-2">Status of Chat</label>
                    <select name="status[]" required class="w-full p-2 mb-3 border border-gray-300 rounded-md">
                        <option value="Client Offline">Client Offline</option>
                        <option value="Closed">Closed</option>
                        <option value="Escalated">Escalated</option>
                    </select>

                    <label class="block mb-2">Issue Type</label>
                    <select name="issueType[]" required class="w-full p-2 mb-3 border border-gray-300 rounded-md">
                        <option value="Technical">Technical</option>
                        <option value="Billing">Billing</option>
                        <option value="General Query">General Query</option>
                    </select>

                    <label class="block mb-2">Called Client</label>
                    <select name="calledClient[]" required class="w-full p-2 mb-3 border border-gray-300 rounded-md">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>

                    <label class="block mb-2">Comments</label>
                    <input type="text" name="comment[]" class="w-full p-2 mb-3 border border-gray-300 rounded-md">

                    <label class="block mb-2">Chat Link</label>
                    @php
                        $chatLinks = old('chatLink', [""]); 
                    @endphp
                    @foreach ($chatLinks as $index=> $link)
                    <div>
                        <input type="text" name="chatLink[]"  value="{{ $link }}" class="w-full p-2 border border-gray-300 rounded-md" >
                        @error("chatLink.$index") 
                            <p class='text-red-500 text-s font-bold mt-1'>{{ $message }}</p>
                        @enderror
                        
                    </div>
                    @endforeach                   
                </div>
            </div>             
            <div class="px-4 py-6 flex justify-between">
                <button type="button" onclick="addMoreEntries()" class="text-blue-500 font-semibold">Add More Entries</button>
                <button form="multiEntryForm" type="submit" class="text-blue-500 font-semibold">Submit</button>
            </div>
        </form>

        <script>
            function addMoreEntries() {
                const firstEntryGroup = document.querySelector('.entry-group');
                const newEntryGroup = firstEntryGroup.cloneNode(true);

                // Clear input values except for the email address
                newEntryGroup.querySelectorAll('input, select').forEach(field => {
                    if (field.type === 'text' && field.name !== 'emailAddress[]') {
                        field.value = '';
                    }
                    if (field.tagName === 'SELECT') {
                        field.selectedIndex = 0;
                    }
                });

                // Set email address for the new entry
                newEntryGroup.querySelector('input[name="emailAddress[]"]').value = "{{ Auth::user()->email }}";

                document.getElementById('entryContainer').appendChild(newEntryGroup);
            }

            function removeEntry(button) {
                const entryGroups = document.querySelectorAll('.entry-group');
                if (entryGroups.length > 1) {
                    const entryGroup = button.closest('.entry-group');
                    entryGroup.remove();
                } else {
                    alert("At least one form entry must remain.");
                }
            }
        </script>

        <style>
            /* CSS to place the cancel button at the top right inside the form entry */
            .cancel-button {
                position: absolute;
                top: 0.5rem;
                right: 0.5rem;
                background: none;
                border: none;
                cursor: pointer;
            }
        </style>
    </body>
</x-app-layout>
