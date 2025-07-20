<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Job Title -->
    <div class="md:col-span-2">
        <x-input-label for="title" value="Job Title *" />
        <x-text-input id="title" name="title" class="mt-1 block w-full focus:border-teal-500 focus:ring-teal-500"
            :value="old('title', $job->title ?? '')" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <!-- Location -->
    <div>
        <x-input-label for="location" value="Location *" />
        <x-text-input id="location" name="location" class="mt-1 block w-full focus:border-teal-500 focus:ring-teal-500"
            :value="old('location', $job->location ?? '')" required placeholder="e.g., New York, NY or Remote" />
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
    </div>

    <!-- Salary -->
    <div>
        <x-input-label for="salary" value="Salary Range" />
        <x-text-input id="salary" name="salary" class="mt-1 block w-full focus:border-teal-500 focus:ring-teal-500"
            :value="old('salary', $job->salary ?? '')" placeholder="e.g., $80,000 - $100,000" />
        <x-input-error :messages="$errors->get('salary')" class="mt-2" />
    </div>

    <!-- Job Type -->
    <div>
        <x-input-label for="type" value="Job Type *" />
        <select name="type" id="type"
            class="mt-1 block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm">
            @foreach (['Full-time', 'Part-time', 'Contract', 'Internship'] as $type)
                <option value="{{ $type }}" @selected(old('type', $job->type ?? '') == $type)>{{ $type }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>

    <!-- Status (Only for Edit form) -->
    @isset($job)
        <div>
            <x-input-label for="status" value="Status *" />
            <select name="status" id="status"
                class="mt-1 block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm">
                <option value="open" @selected(old('status', $job->status) == 'open')>Open</option>
                <option value="closed" @selected(old('status', $job->status) == 'closed')>Closed</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    @endisset

    <!-- Description -->
    <div class="md:col-span-2">
        <x-input-label for="description" value="Job Description *" />
        <textarea id="description" name="description" rows="10"
            class="mt-1 block w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm">{{ old('description', $job->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
</div>
