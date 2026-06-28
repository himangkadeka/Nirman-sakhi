<tbody>
                <!-- Placeholder for application data -->
                <tr>
                    @foreach ($applications as $application)
                <tr>
                    <td>{{ $application->application_id }}</td>
                    <td>{{ $application->benefit->name }}</td>
                    <td>
                        @if ($application->submitted_at == null)
                            --
                        @else
                            {{ \Carbon\Carbon::parse($application->submitted_at)->format('d-m-Y, h:i A') }}
                        @endif
                    </td>
                    <td>
                        @if ($application->status == null)
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-success">{{ $application->status }}</span>
                        @endif
                    </td>
                    <td>
                        @if ($application->status == 'draft' || is_null($application->status))
                            {{-- Action when the application is still a draft --}}
                            <a href="{{ route('worker.complete-application', $application->id) }}"
                                class="btn btn-warning btn-sm shadow-sm">
                                <i class="fas fa-edit me-1"></i> Complete Application
                            </a>
                        @else
                            <div class="btn-group" role="group" aria-label="Application Actions">

                                <a href="{{ route('worker.download-acknowledgment', $application->id) }}"
                                    target="_blank" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                    title="Download Acknowledgment Slip">
                                    <i class="fas fa-receipt"></i>
                                </a>

                                <a href="{{ route('worker.print-application', $application->id) }}" target="_blank"
                                    class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                    title="Download Full Application PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>

                                <button type="button" class="btn btn-sm btn-outline-secondary track-button"
                                    data-application-id="{{ $application->id }}" data-bs-toggle="tooltip"
                                    title="Track Application Status">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>

                            </div>
                            @if ($application->status == 'reverted')
                                <a href="{{ route('worker.apply-now', $application->benefit->id) }}"
                                    class="btn btn-warning btn-sm shadow-sm">
                                    <i class="fas fa-edit me-1"></i> Resubmit Application
                                </a>
                            @endif
                        @endif
                    </td>
                    @endforeach
                </tr>
            </tbody>


