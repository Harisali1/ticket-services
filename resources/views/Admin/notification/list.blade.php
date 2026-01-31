<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Type</th>
            <th>Title</th>
            <th>Message</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($notifications as $notification)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                {{ optional($notification->notifiable)->name ?? 'System' }}
            </td>
            <td>
                <span class="badge bg-info">
                    {{ $notification->data['type'] ?? '-' }}
                </span>
            </td>
            <td>{{ $notification->data['title'] ?? '-' }}</td>
            <td>{{ $notification->data['message'] ?? '-' }}</td>
            <td>
                @if($notification->read_at)
                    <span class="badge bg-success">Read</span>
                @else
                    <span class="badge bg-warning">Unread</span>
                @endif
            </td>
            <td>{{ $notification->created_at->format('d M Y H:i') }}</td>
            <td>
                <a href="{{ $notification->data['url'] ?? '#' }}"
                   class="btn btn-sm btn-primary"
                   target="_blank">
                   Open
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $notifications->links() }}



