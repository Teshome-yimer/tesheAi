
<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use App\Repositories\CourseRepository;

class CourseService
{
    public function __construct(
        protected CourseRepository $courseRepository
    ) {}

    /**
     * Get published course details.
     */
    public function getCourseDetails(string $slug): Course
    {
        return $this->courseRepository->findPublishedBySlug($slug);
    }

    /**
     * Check if user is enrolled in the given course.
     */
    public function isUserEnrolled(?User $user, int $courseId): bool
    {
        if (!$user) {
            return false;
        }

        return $user->isEnrolledIn($courseId);
    }

    /**
     * Determine if the enrolled user should be redirected to VIP Telegram channel.
     */
    public function shouldRedirectToVipTelegram(bool $isEnrolled, string $slug): bool
    {
        return $isEnrolled && $slug === 'vip-telegram-access-all-premium-courses';
    }
}
