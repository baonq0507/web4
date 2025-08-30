<tr>
    <td class="px-2 py-4 whitespace-nowrap text-sm text-white">{{ $user->name }}</td>
    <td class="px-2 py-4 whitespace-nowrap text-sm text-white">{{ substr($user->phone, 0, -4) . '****' }}</td>
    <td class="px-2 py-4 whitespace-nowrap text-sm text-white">{{ $user->created_at->format('d/m/Y H:i') }}</td>
</tr> 