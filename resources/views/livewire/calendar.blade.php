<div>
    <div wire:ignore>
        <div id="calendar"></div>
    </div>

    <style>
        #calendar {
            max-width: 1100px;
            margin: 0 auto;
            padding-bottom: 1rem;
        }

        dialog {
            max-width: 500px;
            width: 90%;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            padding: 1.5rem;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        dialog::backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        dialog h2 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #333;
        }

        dialog ul {
            list-style: none;
            padding: 0;
            margin-bottom: 1rem;
        }

        dialog ul li {
            padding: 0.5rem 0;
            color: #555;
        }

        dialog ul li.text-muted {
            color: #888;
            font-style: italic;
        }

        dialog .modal-footer {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        dialog button,
        dialog a {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        dialog button.close {
            background-color: #e5e7eb;
            color: #374151;
        }

        dialog button.close:hover {
            background-color: #d1d5db;
        }

        dialog a.create {
            background-color: rgb(248 113 113);
            color: #fff;
        }

        dialog a.create:hover {
            background-color: rgb(248 113 113);
        }
    </style>

    @if($showModal)
    <dialog open>
        <h2>Atendimentos em {{ $selectedDate ?? 'Data não selecionada' }}</h2>
        <ul>
            @if(empty($appointments))
            <li class="text-muted">Nenhum agendamento encontrado.</li>
            @else
            @foreach ($appointments as $appointment)
            <li>
                {{ $appointment['date'] ? \Carbon\Carbon::parse($appointment['date'])->format('H:i') : 'Horário inválido' }}
                - {{ $appointment['title'] ?? 'Sem tipo' }}
            </li>
            @endforeach
            @endif
        </ul>
        <div class="modal-footer">
            <button wire:click="closeModal" class="close">Fechar</button>
            <a href="appointments/create" class="create">Novo Agendamento</a>
        </div>
    </dialog>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                events: @json($events),
                dateClick: function(info) {
                    @this.call('selectDate', info.dateStr);
                },
                locale: 'pt-br',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                selectable: false,
                unselectAuto: true,
                editable: false,
                buttonText: {
                    today: "Hoje",
                    month: "Mês",
                    week: "Semana",
                    day: "Dia",
                }
            });

            calendar.render();
        });
    </script>
</div>