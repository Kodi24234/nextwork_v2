 <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" x-cloak>
     <div @click.away="open = false" class="bg-white rounded-xl shadow-lg p-6 max-w-sm w-full mx-4">
         <h2 class="text-lg font-semibold text-gray-800 mb-3">Delete Job?</h2>
         <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete <strong>{{ $job->title }}</strong>? This
             action cannot be undone.</p>

         <div class="flex justify-end gap-3">
             <button @click="open = false"
                 class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">
                 Cancel
             </button>

             <form method="POST" action="{{ route('company.jobs.destroy', $job) }}">
                 @csrf
                 @method('DELETE')
                 <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                     Yes, Delete
                 </button>
             </form>
         </div>
     </div>
 </div>
