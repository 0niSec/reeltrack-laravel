@props(['credits'])

<div x-data="{ activeTab: 'cast' }">
    {{-- Tabs --}}
    <div class="flex gap-4 border-b border-neutral-700">
        <button
            type="button"
            class="pb-2 font-bold"
            :class="activeTab === 'cast' ? 'text-primary-500 font-bold border-b-2 border-primary-500' : 'text-primary-400 font-bold'"
            @click="activeTab = 'cast'"
        >
            Cast
        </button>
        <button
            type="button"
            class="pb-2 font-bold"
            :class="activeTab === 'crew' ? 'text-primary-500 font-bold border-b-2 border-primary-500' : 'text-primary-400 font-bold'"
            @click="activeTab = 'crew'"
        >
            Crew
        </button>
    </div>

    {{-- Cast Tab --}}
    <div x-show="activeTab === 'cast'" class="mt-4">
        <div class="grid grid-cols-2 gap-4">
            @foreach (collect($credits['cast'])->take(6) as $castMember)
                <div class="flex items-center gap-3">
                    <img
                        src="{{ $castMember['profile_path'] ?? '#' }}"
                        alt="{{ $castMember['name'] ?? 'Unknown Actor' }}"
                        class="w-12 h-12 rounded-full object-cover"
                    />
                    <div>
                        <div class="font-medium">{{ $castMember['name'] }}</div>
                        <div class="text-sm font-medium text-primary-400">
                            {{ $castMember['character'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Crew Tab --}}
    <div x-show="activeTab === 'crew'" class="mt-4">
        <div class="grid grid-cols-2 gap-4">
            @foreach (collect($credits['crew'])->take(6) as $crewMember)
                <div class="flex items-center gap-3">
                    <img
                        src="{{ $crewMember['profile_path'] ?? '#' }}"
                        alt="{{ $crewMember['name'] ?? 'Unknown Crew Member' }}"
                        class="w-12 h-12 rounded-full object-cover"
                    />
                    <div>
                        <div class="font-medium">{{ $crewMember['name'] }}</div>
                        <div class="text-sm font-medium text-primary-400">
                            {{ $crewMember['department'] }}
                        </div>
                        <div class="text-xs text-primary-400">
                            {{ $crewMember['job'] }}
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
