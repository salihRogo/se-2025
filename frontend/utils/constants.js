var Constants = {
    get_api_base_url: function() {
        // Check if we're in production (Heroku) or development environment
        var host = window.location.hostname;
        if (host === 'localhost' || host === '127.0.0.1') {
            return "http://localhost:8888/se-2025/backend/";
        } else {
            // In production, API is at the same domain but with '/backend' path
            return window.location.origin + "/backend/";
        }
    }
}