const API_URL  = 'http://api.cc.localhost';
async function fetchCategoryData() {
    try {
        const response = await fetch(`${API_URL}/categories/tree`);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        return await response.json();
    } catch (error) {
        console.error('Error fetching category data:', error);
        document.getElementById('category-menu').innerHTML = 'Failed to load categories.';

        return null;
    }
}

function generateCategoryMenu(categories) {
    const ul = document.createElement('ul');

    categories.forEach(category => {
        const li = document.createElement('li');
        li.dataset.categoryId = category.id;
        li.dataset.categoryName = category.name;

        li.className = 'menu-item'
        li.innerHTML = `
          <span class="category">${category.name}</span>
          <span class="count">(${category.count_of_courses})</span>
        `;

        if (category.children && category.children.length > 0) {
            li.appendChild(generateCategoryMenu(category.children));
        }

        ul.appendChild(li);
    });

    return ul;
}

function addCategoryClickListener() {
    const categoryMenu = document.getElementById('category-menu');
    const categoryTitle = document.getElementById('category-title');

    categoryMenu.addEventListener('click', (event) => {
        const target = event.target.closest('li');
        if (target && target.dataset.categoryId) {
            const categoryId = target.dataset.categoryId;
            const categoryName = target.dataset.categoryName;

            categoryTitle.innerText = categoryName;

            const activeElement = categoryMenu.querySelector('span.category.active');
            if (activeElement) {
                activeElement.classList.remove('active');
            }

            const categorySpan = target.querySelector('span.category');
            if (categorySpan) {
                categorySpan.classList.add('active');
            }

            loadCourses('category', categoryId);
        }
    });
}

async function renderCategoryMenu() {
    const categoryData = await fetchCategoryData();
    if (categoryData) {
        const categoryMenu = document.getElementById('category-menu');
        categoryMenu.innerHTML = '';
        categoryMenu.appendChild(generateCategoryMenu(categoryData));
        addCategoryClickListener();
    }
}

async function  loadCourses(type = 'initial', id) {
    const apiUrl =  type === 'initial'
        ? `${API_URL}/courses`
        : `${API_URL}/courses/category/${id}`;

    const coursesContainer = document.getElementById('courses');

    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const courses = await response.json();

        coursesContainer.innerHTML = '';

        if (courses.length === 0) {
            coursesContainer.innerHTML = '<p>This category doesn\'t have any courses.</p>';
        } else {
            courses.forEach(course => {
                const courseHtml = `
                    <div class="course">
                        <p class="chip">${course.main_category_name}</p>
                        <img alt="course image" class="image" src="${course.preview}">

                        <div class="content">
                            <h4 class="title">${course.name}</h4>

                            <p class="description">
                                ${course.description}
                            </p>
                        </div>
                    </div>
                `;
                coursesContainer.insertAdjacentHTML('beforeend', courseHtml);
            });
        }
    } catch (error) {
        console.error('Failed to load courses:', error);
        coursesContainer.innerHTML = '<p>Failed to load courses. Please try again later.</p>';
    }
}

document.addEventListener('DOMContentLoaded', ()=> {
    loadCourses();
    renderCategoryMenu();
});
