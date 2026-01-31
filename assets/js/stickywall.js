document.addEventListener("DOMContentLoaded", () => {
    const board = document.getElementById("stickyBoard");
    const addBtn = document.getElementById("addNoteBtn");

    if (!board || !addBtn) return;

    /* =========================
       DRAG & DROP
    ========================= */
    let draggedNote = null;
    let offsetX = 0;
    let offsetY = 0;

    board.addEventListener("mousedown", (e) => {
        const note = e.target.closest(".sticky-note");
        if (!note) return;

        // Không kéo nếu đang click vào textarea hoặc nút xóa
        if (e.target.tagName === "TEXTAREA" || e.target.closest(".delete-note")) {
            return;
        }

        draggedNote = note;
        const rect = note.getBoundingClientRect();
        const boardRect = board.getBoundingClientRect();

        offsetX = e.clientX - rect.left;
        offsetY = e.clientY - rect.top;

        note.style.cursor = "grabbing";
        note.style.zIndex = 1000;

        e.preventDefault();
    });

    document.addEventListener("mousemove", (e) => {
        if (!draggedNote) return;

        const boardRect = board.getBoundingClientRect();
        let newX = e.clientX - boardRect.left - offsetX;
        let newY = e.clientY - boardRect.top - offsetY;

        // Giới hạn trong board
        newX = Math.max(0, Math.min(newX, boardRect.width - draggedNote.offsetWidth));
        newY = Math.max(0, Math.min(newY, boardRect.height - draggedNote.offsetHeight));

        draggedNote.style.left = newX + "px";
        draggedNote.style.top = newY + "px";
    });

    document.addEventListener("mouseup", (e) => {
        if (!draggedNote) return;

        draggedNote.style.cursor = "grab";
        draggedNote.style.zIndex = "";

        // Lưu vị trí mới vào database
        const id = draggedNote.dataset.id;
        if (id) {
            const content = draggedNote.querySelector("textarea").value;
            const posX = parseInt(draggedNote.style.left);
            const posY = parseInt(draggedNote.style.top);

            const data = new URLSearchParams();
            data.append("id", id);
            data.append("content", content);
            data.append("pos_x", posX);
            data.append("pos_y", posY);

            fetch("api/sticky/update.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: data
            })
            .then(res => res.json())
            .then(r => {
                if (!r.success) {
                    console.error("Failed to save position");
                }
            });
        }

        draggedNote = null;
    });

    /* =========================
       ADD NOTE
    ========================= */
    addBtn.addEventListener("click", () => {
        // Random color selection
        const colors = ['yellow', 'pink', 'blue', 'green', 'purple'];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];

        const rect = board.getBoundingClientRect();
        const offset = board.querySelectorAll(".sticky-note").length * 24;
        
        const posX = Math.floor(rect.width / 2 - 110 + offset);
        const posY = Math.floor(rect.height / 2 - 75 + offset);

        // Save to database immediately with empty content
        const data = new URLSearchParams();
        data.append("content", "");
        data.append("pos_x", posX);
        data.append("pos_y", posY);
        data.append("color", randomColor);

        fetch("api/sticky/create.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: data
        })
        .then(res => res.json())
        .then(r => {
            if (r.success) {
                // Reload to get the new note with proper ID
                location.reload();
            } else {
                alert("Failed to create note");
            }
        })
        .catch(err => {
            console.error("Error creating note:", err);
            alert("Error creating note");
        });
    });

    /* =========================
       DELETE NOTE
    ========================= */
    board.addEventListener("click", (e) => {
        const btn = e.target.closest(".delete-note");
        if (!btn) return;

        e.stopPropagation();

        const note = btn.closest(".sticky-note");
        const id = note.dataset.id;

        if (!id) {
            note.remove();
            return;
        }

        fetch("api/sticky/delete.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(r => {
            console.log("DELETE RESPONSE:", r);
            if (r.success) {
                note.remove();
            } else {
                alert("Delete failed");
            }
        });
    });

    /* =========================
       AUTO-SAVE CONTENT
    ========================= */
    board.addEventListener("blur", (e) => {
        if (e.target.tagName !== "TEXTAREA") return;

        const note = e.target.closest(".sticky-note");
        const id = note.dataset.id;
        
        if (!id) return;

        const content = e.target.value.trim();
        const posX = parseInt(note.style.left);
        const posY = parseInt(note.style.top);

        const data = new URLSearchParams();
        data.append("id", id);
        data.append("content", content);
        data.append("pos_x", posX);
        data.append("pos_y", posY);

        fetch("api/sticky/update.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: data
        })
        .then(res => res.json())
        .then(r => {
            if (r.success) {
                console.log("Content saved");
            }
        });
    }, true);

    // Set cursor grab cho tất cả notes hiện có
    document.querySelectorAll(".sticky-note").forEach(note => {
        note.style.cursor = "grab";
    });

    // Auto-focus vào note mới nhất (note cuối cùng)
    const allNotes = document.querySelectorAll(".sticky-note");
    if (allNotes.length > 0) {
        const lastNote = allNotes[allNotes.length - 1];
        const textarea = lastNote.querySelector("textarea");
        if (textarea && textarea.value.trim() === "") {
            // Chỉ focus nếu note trống (mới tạo)
            setTimeout(() => {
                textarea.focus();
            }, 100);
        }
    }

});