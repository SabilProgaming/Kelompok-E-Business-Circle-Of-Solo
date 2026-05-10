@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
	<div x-data="messagesPage()" class="space-y-6">
		<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 border-b border-gray-100 -mx-4 sm:-mx-6 lg:-mx-8 -mt-4 sm:-mt-6 lg:-mt-8 mb-6 shadow-sm">
			<div>
				<h2 class="text-2xl font-serif text-[#0F0F0F] font-bold tracking-tight">Contact Messages</h2>
				<p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest font-bold">
					{{ $unreadCount }} unread message{{ $unreadCount !== 1 ? 's' : '' }}
				</p>
			</div>
		</div>

		@if(session('success'))
			<div class="px-4 py-3 border border-green-200 bg-green-50 text-green-700 text-sm rounded">
				{{ session('success') }}
			</div>
		@endif

		<x-admin.ui.card>
			<div class="overflow-x-auto">
				<table class="w-full text-left border-collapse">
					<thead>
					<tr class="border-b-2 border-gray-100">
						<th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest w-8"></th>
						<th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Name</th>
						<th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email</th>
						<th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Inquiry</th>
						<th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</th>
						<th class="px-6 py-4 font-medium text-right">Actions</th>
					</tr>
					</thead>
					<tbody class="divide-y divide-gray-100">
					@forelse($messages as $msg)
						<tr class="hover:bg-[#F8F8F8] transition-colors {{ !$msg->is_read ? 'bg-blue-50/30' : '' }}" id="row-{{ $msg->id }}">
							<td class="px-6 py-4">
								@if(!$msg->is_read)
									<span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500" id="indicator-{{ $msg->id }}"></span>
								@endif
							</td>
							<td class="px-6 py-4 font-medium text-gray-900 {{ !$msg->is_read ? 'font-bold' : '' }}">{{ $msg->name }}</td>
							<td class="px-6 py-4 text-gray-500 text-sm">{{ $msg->email }}</td>
							<td class="px-6 py-4">
								<x-admin.ui.badge variant="info">{{ $msg->inquiry_type }}</x-admin.ui.badge>
							</td>
							<td class="px-6 py-4 text-gray-500 text-sm">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
							<td class="px-6 py-4 text-right space-x-1">
								<x-admin.ui.button type="button" variant="ghost" class="px-2 py-1"
									@click="openDetail({{ $msg->id }}, {{ Js::from($msg) }})">
									<i data-lucide="eye" class="w-4 h-4 mr-1"></i>
									View
								</x-admin.ui.button>
								<form method="POST" action="{{ route('admin.contact-messages.destroy', $msg) }}" class="inline" onsubmit="return confirm('Delete this message?')">
									@csrf
									@method('DELETE')
									<x-admin.ui.button variant="ghost" class="px-2 py-1 text-red-500 hover:text-red-700" type="submit">
										<i data-lucide="trash-2" class="w-4 h-4"></i>
									</x-admin.ui.button>
								</form>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="px-6 py-8 text-center text-gray-400">No messages yet.</td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>

			@if($messages->hasPages())
				<div class="px-6 py-4 border-t border-gray-100">
					{{ $messages->links() }}
				</div>
			@endif
		</x-admin.ui.card>

		{{-- Detail Modal --}}
		<x-admin.modal open="isDetailOpen" titleVar="modalTitle" maxWidth="max-w-2xl">
			<template x-if="selectedMsg">
				<div class="space-y-6">
					<div class="grid grid-cols-2 gap-4 text-sm">
						<div>
							<p class="text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-1">From</p>
							<p class="font-medium text-gray-900" x-text="selectedMsg.name"></p>
						</div>
						<div>
							<p class="text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-1">Email</p>
							<p class="text-gray-700" x-text="selectedMsg.email"></p>
						</div>
						<div>
							<p class="text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-1">Inquiry Type</p>
							<p class="text-gray-700" x-text="selectedMsg.inquiry_type"></p>
						</div>
						<div>
							<p class="text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-1">Date</p>
							<p class="text-gray-700" x-text="new Date(selectedMsg.created_at).toLocaleString('id-ID')"></p>
						</div>
					</div>

					<div>
						<p class="text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-2">Message</p>
						<div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-800 leading-relaxed whitespace-pre-wrap" x-text="selectedMsg.message"></div>
					</div>
				</div>
			</template>
		</x-admin.modal>
	</div>

	<script>
		function messagesPage() {
			return {
				selectedMsg: null,
				isDetailOpen: false,
				modalTitle: 'Message Detail',

				openDetail(id, msg) {
					this.selectedMsg = msg;
					this.isDetailOpen = true;

					if (!msg.is_read) {
						fetch(`/admin/contact-messages/${id}`)
							.then(res => res.json())
							.then(data => {
								msg.is_read = true;
								// Visually mark as read
								document.getElementById(`row-${id}`)?.classList.remove('bg-blue-50/30');
								document.getElementById(`indicator-${id}`)?.remove();
							});
					}
				}
			};
		}
	</script>
@endsection
