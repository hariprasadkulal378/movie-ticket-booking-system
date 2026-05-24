// This file handles small browser interactions for the booking app.

document.addEventListener('DOMContentLoaded', function () {
    const navToggle = document.querySelector('.nav-toggle');
    const navLinks = document.querySelector('.nav-links');

    if (navToggle && navLinks) {
        navToggle.addEventListener('click', function () {
            navLinks.classList.toggle('open');
        });
    }

    const movieSearch = document.getElementById('movieSearch');
    const movieCards = document.querySelectorAll('.searchable-movie');

    if (movieSearch && movieCards.length > 0) {
        movieSearch.addEventListener('input', function () {
            const searchText = movieSearch.value.toLowerCase();

            movieCards.forEach(function (card) {
                const movieText = card.dataset.title;
                card.style.display = movieText.includes(searchText) ? '' : 'none';
            });
        });
    }

    const seats = document.querySelectorAll('.seat:not(.booked)');
    const selectedSeatsInput = document.getElementById('selectedSeats');
    const seatList = document.getElementById('seatList');
    const seatTotal = document.getElementById('seatTotal');
    const showSelect = document.getElementById('showSelect');

    function getPricePerSeat() {
        if (!showSelect || !showSelect.selectedOptions.length) {
            return 180;
        }

        return Number(showSelect.selectedOptions[0].dataset.price || 180);
    }

    function updateSeatSummary() {
        const selectedSeats = Array.from(document.querySelectorAll('.seat.selected')).map(function (seat) {
            return seat.dataset.seat;
        });

        if (selectedSeatsInput) {
            selectedSeatsInput.value = selectedSeats.join(',');
        }

        if (seatList) {
            seatList.textContent = selectedSeats.length > 0 ? selectedSeats.join(', ') : 'None';
        }

        if (seatTotal) {
            seatTotal.textContent = selectedSeats.length * getPricePerSeat();
        }
    }

    seats.forEach(function (seat) {
        seat.addEventListener('click', function () {
            seat.classList.toggle('selected');
            updateSeatSummary();
        });
    });

    if (showSelect) {
        showSelect.addEventListener('change', function () {
            const params = new URLSearchParams(window.location.search);
            params.set('show_id', showSelect.value);
            window.location.search = params.toString();
        });
    }
});
