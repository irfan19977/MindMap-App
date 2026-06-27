@extends('frontend.layouts.app')

@section('content')
    <!-- Header Section -->
    <section class="intro" data-background="{{ asset('frontend/img/main/11.jpg') }}">
        <div class="intro-body">
            <div class="overlay"></div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="no-pad bold">Tim <span class="label classic">Pengajar</span><br>Profesional</h1>
                        <p class="lead">Bergabunglah dengan tim pengajar berpengalaman kami yang berdedikasi untuk membantu Anda mencapai potensi maksimal dalam pembelajaran</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Teachers Section -->
    <section class="showcase section-small">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2>Pengajar Kami</h2>
                    <p>Tim pengajar MindMap terdiri dari profesional berpengalaman di bidangnya masing-masing, siap membimbing Anda dalam perjalanan pembelajaran</p>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="teacher-filter-section">
                        <!-- Search -->
                        <div class="search-box">
                            <div class="input-group">
                                <input type="text" id="teacherSearch" class="form-control" placeholder="Cari pengajar berdasarkan nama atau spesialisasi...">
                                <span class="input-group-addon"><i class="ion-ios-search"></i></span>
                            </div>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="filter-buttons">
                            <button class="btn btn-filter active" data-filter="all">Semua</button>
                            <button class="btn btn-filter" data-filter="akademik">Akademik</button>
                            <button class="btn btn-filter" data-filter="digital">Digital</button>
                            <button class="btn btn-filter" data-filter="bisnis">Bisnis</button>
                        </div>

                        <!-- Sort Options -->
                        <div class="sort-options">
                            <label for="teacherSort">Urutkan:</label>
                            <select id="teacherSort" class="form-control">
                                <option value="default">Default</option>
                                <option value="rating-desc">Rating Tertinggi</option>
                                <option value="rating-asc">Rating Terendah</option>
                                <option value="name-asc">Nama A-Z</option>
                                <option value="name-desc">Nama Z-A</option>
                                <option value="reviews-desc">Review Terbanyak</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row grid-pad" id="teacherGrid">
                @foreach($teachers as $index => $teacher)
                <div class="col-sm-4 teacher-card" data-category="{{ $teacher->category }}" data-name="{{ strtolower($teacher->name . ' ' . $teacher->specialization) }}" data-rating="{{ $teacher->rating }}" data-reviews="{{ $teacher->review_count }}" data-id="{{ $teacher->id }}">
                    <div class="team-member wow fadeIn" data-wow-delay="{{ ($index + 1) * 0.1 }}s">
                        <div class="team-img">
                            <img class="img-responsive center-block" src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}">
                            <div class="team-overlay">
                                <ul class="list-inline">
                                    @if($teacher->linkedin_url)
                                    <li><a href="{{ $teacher->linkedin_url }}" target="_blank"><i class="fab fa-linkedin-in fa-fw fa-lg"></i></a></li>
                                    @endif
                                    @if($teacher->twitter_url)
                                    <li><a href="{{ $teacher->twitter_url }}" target="_blank"><i class="fab fa-twitter fa-fw fa-lg"></i></a></li>
                                    @endif
                                    @if($teacher->github_url)
                                    <li><a href="{{ $teacher->github_url }}" target="_blank"><i class="fab fa-github fa-fw fa-lg"></i></a></li>
                                    @endif
                                    @if($teacher->email)
                                    <li><a href="mailto:{{ $teacher->email }}"><i class="fas fa-envelope fa-fw fa-lg"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="team-info text-center">
                            <div class="teacher-header">
                                <h4>{{ $teacher->name }}</h4>
                                <button class="btn btn-wishlist" data-teacher-id="{{ $teacher->id }}" data-teacher-name="{{ $teacher->name }}"><i class="far fa-heart"></i></button>
                            </div>
                            <p class="text-muted">{{ $teacher->specialization }}</p>
                            <div class="teacher-rating">
                                @php
                                    $fullStars = floor($teacher->rating);
                                    $hasHalfStar = ($teacher->rating - $fullStars) >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                @endphp
                                @for($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star text-warning"></i>
                                @endfor
                                @if($hasHalfStar)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @endif
                                @for($i = 0; $i < $emptyStars; $i++)
                                    <i class="far fa-star text-warning"></i>
                                @endfor
                                <span class="rating-number">{{ number_format($teacher->rating, 1) }}</span>
                                <span class="review-count">({{ $teacher->review_count }} reviews)</span>
                            </div>
                            <p class="small">{{ Str::limit($teacher->description, 100) }}</p>
                            <div class="teacher-actions">
                                <a href="{{ route('teacher.show', $teacher->slug) }}" class="btn btn-sm btn-dark-border">Lihat Profil</a>
                                <button class="btn btn-sm btn-primary btn-quick-view" data-teacher-id="{{ $teacher->id }}">Quick View</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gray text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Bergabung Menjadi Pengajar</h2>
                    <p>Apakah Anda memiliki keahlian yang ingin dibagikan? Bergabunglah dengan tim pengajar MindMap dan berkontribusi dalam mencerdaskan bangsa.</p>
                    <a href="/contact" class="btn btn-dark-border">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for Filter and Search -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality
            const filterButtons = document.querySelectorAll('.btn-filter');
            const teacherCards = document.querySelectorAll('.teacher-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    teacherCards.forEach(card => {
                        if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 10);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });

            // Search functionality
            const searchInput = document.getElementById('teacherSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    teacherCards.forEach(card => {
                        const teacherName = card.getAttribute('data-name');
                        if (teacherName.includes(searchTerm)) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 10);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            }
        });
    </script>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Quick View Modal -->
    <div class="modal-overlay" id="quickViewModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Quick View - Pengajar</h3>
                <button class="modal-close" id="closeModal"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be dynamically loaded -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-dark-border" id="closeModalBtn">Tutup</button>
                <a href="#" class="btn btn-primary" id="modalViewProfile">Lihat Profil Lengkap</a>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Teacher data for quick view - populated from database
            const teacherData = {
                @foreach($teachers as $teacher)
                {{ $teacher->id }}: {
                    id: {{ $teacher->id }},
                    name: {{ json_encode($teacher->name) }},
                    specialization: {{ json_encode($teacher->specialization) }},
                    rating: {{ $teacher->rating }},
                    reviews: {{ $teacher->review_count }},
                    image: {{ json_encode($teacher->image_url) }},
                    description: {{ json_encode($teacher->description) }},
                    slug: {{ json_encode($teacher->slug) }}
                },
                @endforeach
            };

            // Toast notification function
            function showToast(type, title, message) {
                const container = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.className = `toast ${type}`;

                const icons = {
                    success: 'fa-check-circle',
                    info: 'fa-info-circle',
                    warning: 'fa-exclamation-circle'
                };

                toast.innerHTML = `
                    <i class="fas ${icons[type]} toast-icon"></i>
                    <div class="toast-content">
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close"><i class="fas fa-times"></i></button>
                `;

                container.appendChild(toast);

                // Close button functionality
                toast.querySelector('.toast-close').addEventListener('click', () => {
                    toast.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                });

                // Auto remove after 5 seconds
                setTimeout(() => {
                    toast.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            }

            // Load wishlist from localStorage
            function loadWishlist() {
                const wishlist = localStorage.getItem('teacherWishlist');
                return wishlist ? JSON.parse(wishlist) : [];
            }

            // Save wishlist to localStorage
            function saveWishlist(wishlist) {
                localStorage.setItem('teacherWishlist', JSON.stringify(wishlist));
            }

            // Update wishlist button states
            function updateWishlistButtons() {
                const wishlist = loadWishlist();
                document.querySelectorAll('.btn-wishlist').forEach(btn => {
                    const teacherId = btn.getAttribute('data-teacher-id');
                    if (wishlist.includes(teacherId)) {
                        btn.classList.add('active');
                        btn.querySelector('i').classList.remove('far');
                        btn.querySelector('i').classList.add('fas');
                    } else {
                        btn.classList.remove('active');
                        btn.querySelector('i').classList.remove('fas');
                        btn.querySelector('i').classList.add('far');
                    }
                });
            }

            // Wishlist button click handlers
            document.querySelectorAll('.btn-wishlist').forEach(btn => {
                btn.addEventListener('click', function() {
                    const teacherId = this.getAttribute('data-teacher-id');
                    const teacherName = this.getAttribute('data-teacher-name');
                    let wishlist = loadWishlist();

                    if (wishlist.includes(teacherId)) {
                        wishlist = wishlist.filter(id => id !== teacherId);
                        showToast('info', 'Dihapus dari Favorit', `${teacherName} telah dihapus dari daftar favorit Anda.`);
                    } else {
                        wishlist.push(teacherId);
                        showToast('success', 'Ditambahkan ke Favorit', `${teacherName} telah ditambahkan ke daftar favorit Anda.`);
                    }

                    saveWishlist(wishlist);
                    updateWishlistButtons();
                });
            });

            // Initialize wishlist buttons
            updateWishlistButtons();

            // Sorting functionality
            const sortSelect = document.getElementById('teacherSort');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    const sortValue = this.value;
                    const grid = document.getElementById('teacherGrid');
                    const cards = Array.from(grid.querySelectorAll('.teacher-card'));

                    if (sortValue === 'default') {
                        // Restore original order
                        cards.forEach(card => grid.appendChild(card));
                    } else {
                        cards.sort((a, b) => {
                            switch(sortValue) {
                                case 'rating-desc':
                                    return parseFloat(b.getAttribute('data-rating')) - parseFloat(a.getAttribute('data-rating'));
                                case 'rating-asc':
                                    return parseFloat(a.getAttribute('data-rating')) - parseFloat(b.getAttribute('data-rating'));
                                case 'name-asc':
                                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                                case 'name-desc':
                                    return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
                                case 'reviews-desc':
                                    return parseInt(b.getAttribute('data-reviews')) - parseInt(a.getAttribute('data-reviews'));
                                default:
                                    return 0;
                            }
                        });

                        cards.forEach(card => grid.appendChild(card));
                    }
                });
            }

            // Quick View Modal functionality
            const modal = document.getElementById('quickViewModal');
            const modalBody = document.getElementById('modalBody');
            const modalViewProfile = document.getElementById('modalViewProfile');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const closeModal = document.getElementById('closeModal');

            function generateStars(rating) {
                let stars = '';
                const fullStars = Math.floor(rating);
                const hasHalfStar = rating % 1 >= 0.5;

                for (let i = 0; i < fullStars; i++) {
                    stars += '<i class="fas fa-star"></i>';
                }
                if (hasHalfStar) {
                    stars += '<i class="fas fa-star-half-alt"></i>';
                }
                const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
                for (let i = 0; i < emptyStars; i++) {
                    stars += '<i class="far fa-star"></i>';
                }
                return stars;
            }

            document.querySelectorAll('.btn-quick-view').forEach(btn => {
                btn.addEventListener('click', function() {
                    const teacherId = this.getAttribute('data-teacher-id');
                    const teacher = teacherData[teacherId];

                    if (teacher) {
                        modalBody.innerHTML = `
                            <div class="modal-teacher-info">
                                <img src="${teacher.image}" alt="${teacher.name}" class="modal-teacher-img">
                                <div class="modal-teacher-details">
                                    <h4>${teacher.name}</h4>
                                    <p class="text-muted">${teacher.specialization}</p>
                                    <div class="modal-teacher-rating">
                                        ${generateStars(teacher.rating)}
                                        <span>${teacher.rating}</span>
                                        <span class="text-muted">(${teacher.reviews} reviews)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-teacher-description">
                                <p>${teacher.description}</p>
                            </div>
                        `;

                        modalViewProfile.href = `/teacher/${teacher.slug}`;
                        modal.classList.add('active');
                    }
                });
            });

            function hideModal() {
                modal.classList.remove('active');
            }

            closeModal.addEventListener('click', hideModal);
            closeModalBtn.addEventListener('click', hideModal);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    hideModal();
                }
            });

            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    hideModal();
                }
            });
        });
    </script>
@endsection
