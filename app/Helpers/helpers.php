<?php

if (!function_exists('foto_profil_url')) {
    /**
     * Get the correct URL for a foto_profil value.
     * Handles: base64 data URLs, full URLs (http/https), and local storage paths.
     */
    function foto_profil_url(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        // Already a base64 data URL - return as-is
        if (str_starts_with($path, 'data:')) {
            return $path;
        }

        // Already a full URL (e.g., from Supabase) - return as-is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Local storage path - use asset() helper
        return asset($path);
    }
}
