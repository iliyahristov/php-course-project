function openAddStudentModal() {
    document.getElementById('addStudentModal').style.display = 'block';
}

function openAddLectureModal(studentId) {
    document.getElementById('student_id').value = studentId;
    document.getElementById('addLectureModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addStudentForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('save_student', '1');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                alert('Студентът е добавен успешно.');
                window.location.reload();
            })
            .catch(error => {
                alert('Грешка при добавяне на студент: ' + error);
            });
    };

    document.getElementById('addLectureForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('save_lecture', '1');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                alert('Лекцията е добавена успешно.');
                window.location.reload();
            })
            .catch(error => {
                alert('Грешка при добавяне на лекция: ' + error);
            });
    };
});