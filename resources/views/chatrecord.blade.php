<x-app-layout>
<x-slot name="header">
    <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
        <div>Chat Records</div>
        <div class="text-center">
            <label for="chat-count" class="block text-xl font-semibold text-gray-800">Chat Count</label>
            <div class="relative mt-2 flex justify-center space-x-6">
                <div >
                    <x-header-label> Today </x-header-label>
                    <x-header-input name="today_count" id="today_count" value="{{ $todayCount }}" />
                </div>
                <div>
                    <x-header-label> This Week </x-header-label>
                    <x-header-input name="week_count" id="week_count" value="{{ $weekCount }}"/>
                </div>
                <div>
                    <x-header-label> This Month </x-header-label>
                    <x-header-input name="month_count" id="month_count" value="{{ $monthCount }}" />
                </div>
            </div>
        </div>
    </h2>
</x-slot>


<x-table>
    <thead>
        <tr class="bg-gray-100">
            <th class="py-2 px-4 border-b text-left">Timestamp</th>

            <!-- Status Dropdown -->
            <x-table-header> 
                <x-dropdown-p-button id="status-menu-button" onclick="toggleDropdown('status-menu')">
                    Status
                    <x-arrow-svg/>
                </x-dropdown-p-button>

                <div id="status-menu" class="dropdown-menu hidden absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                    <x-dropdown-s-button onclick="filterTable('status_of_chat', '')">All</x-dropdown-s-button>
                    <x-dropdown-s-button onclick="filterTable('status_of_chat', 'Escalated')">Escalated</x-dropdown-s-button>
                    <x-dropdown-s-button onclick="filterTable('status_of_chat', 'Closed')">Closed</x-dropdown-s-button>
                </div>
            </x-table-header>

            <!-- Issue Type Dropdown -->
            <x-table-header> 
                <x-dropdown-p-button id="issue-menu-button" onclick="toggleDropdown('issue-menu')">
                    Issue Type
                    <x-arrow-svg/>
                </x-dropdown-p-button>

                <div id="issue-menu" class="dropdown-menu hidden absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                    <x-dropdown-s-button onclick="filterTable('issue_type', '')">All</x-dropdown-s-button>
                    <x-dropdown-s-button onclick="filterTable('issue_type', 'Technical')">Technical</x-dropdown-s-button>
                    <x-dropdown-s-button onclick="filterTable('issue_type', 'General Query')">General Query</x-dropdown-s-button>
                </div>
            </x-table-header>

            <!-- Called Clients Dropdown -->
            <x-table-header>
                <x-dropdown-p-button id="called-menu-button" onclick="toggleDropdown('called-menu')">
                    Called Cilents
                    <x-arrow-svg/>
                </x-dropdown-p-button>

                <div id="called-menu" class="dropdown-menu hidden absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                    <x-dropdown-s-button onclick="filterTable('called_client', '')">All</x-dropdown-s-button>
                    <x-dropdown-s-button onclick="filterTable('called_client', 'Yes')">Yes</x-dropdown-s-button>
                    <x-dropdown-s-button onclick="filterTable('called_client', 'No')">No</x-dropdown-s-button>
                </div>
            </x-table-header>

            <th class="py-2 px-4 border-b text-left">Comments</th>
            <th class="py-2 px-4 border-b text-left">Chat Links</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <x-table-data>{{ $row->created_at ?? '' }}</x-table-data>
                <x-table-data>{{ $row->status_of_chat ?? '' }}</x-table-data>
                <x-table-data>{{ $row->issue_type ?? '' }}</x-table-data>
                <x-table-data>{{ $row->called_cilent ?? '' }}</x-table-data>
                <x-table-data>{{ $row->comments ?? '' }}</x-table-data>
                <x-table-data>
                    <a href="{{ $row->chat_link ?? '#' }}" target="_blank" class="text-blue-500 underline">View Chat</a>
                </x-table-data>
            </tr>
        @endforeach
    </tbody>    
</x-table>

<div class=" px-6 mt-4">
    {{ $data->links() }}
</div>





<script>
    // Toggle dropdown visibility
    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);

        // Close all other dropdowns first
        document.querySelectorAll('.dropdown-menu').forEach((dropdown) => {
            if (dropdown !== menu) {
                dropdown.classList.add('hidden');
            }
        });

        // Toggle the current dropdown
        menu.classList.toggle('hidden');
    }

    // Filter the table rows based on selected option
    function filterTable(column, value) {
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            // Get the cell value based on the column index
            const cellValue = getCellValue(row, column);

            // Show or hide the row based on the selected value
            if (value === '' || cellValue === value) {
                row.style.display = ''; // Show the row
            } else {
                row.style.display = 'none'; // Hide the row
            }
        });
    }

    // Get the text content of a specific column in a row
    function getCellValue(row, column) {
        const columnMap = {
            'status_of_chat': 2, // Column index for Status
            'issue_type': 3,     // Column index for Issue Type
            'called_client': 4,  // Column index for Called Clients
        };

        const cell = row.querySelector(`td:nth-child(${columnMap[column]})`);
        return cell ? cell.textContent.trim() : '';
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
        const isDropdownButton = event.target.closest('[aria-haspopup="true"]');
        const isDropdownMenu = event.target.closest('.dropdown-menu');

        if (!isDropdownButton && !isDropdownMenu) {
            document.querySelectorAll('.dropdown-menu').forEach((dropdown) => {
                dropdown.classList.add('hidden');
            });
        }
    });
</script>



</x-app-layout>
