function updateTaskStatus(taskId) {
    fetch(`/tasks/${taskId}/status`)
        .then(response => response.json())
        .then(data => {
            console.log(`Task ${taskId} New Status:`, data.status); // Debugging Line
            document.getElementById(`task-status-${taskId}`).textContent = data.status;
        })
        .catch(error => console.error('Error fetching task status:', error));
}

// Call this function every few seconds to auto-update statuses
setInterval(() => {
    document.querySelectorAll("[id^='task-status-']").forEach(element => {
        const taskId = element.id.split('-').pop();
        updateTaskStatus(taskId);
    });
}, 5000); // Refresh every 5 seconds
