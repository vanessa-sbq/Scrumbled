document.addEventListener('DOMContentLoaded', () => {
    const defaultAccordionGroup = document.querySelector('.accordion-group[data-accordion="default-accordion"]');
    if (defaultAccordionGroup) {
        defaultAccordion(defaultAccordionGroup);
    }
});

function defaultAccordion(defaultAccordionGroup) {
    const accordionButtons = defaultAccordionGroup.querySelectorAll('.accordion-toggle');

    accordionButtons.forEach(button => {
        button.addEventListener('click', () => {
            const accordion = button.parentElement;
            const content = button.nextElementSibling;
            const isOpen = content.style.maxHeight !== '';
            const chevron = button.querySelector('.chevron');

            // Close all open accordions before opening the clicked one
            if (isOpen) {
                close(button);
                content.style.maxHeight = '';
                accordion.classList.remove('active');
                chevron.style.transform = 'rotate(0deg)';
            } else {
                // Close other accordions first
                const otherButtons = defaultAccordionGroup.querySelectorAll('.accordion-toggle');
                otherButtons.forEach(otherButton => {
                    if (otherButton !== button) {
                        const otherAccordion = otherButton.parentElement;
                        close(otherButton);
                        otherAccordion.classList.remove('active');
                    }
                });

                content.style.maxHeight = content.scrollHeight + 'px';
                accordion.classList.add('active');
                chevron.style.transform = 'rotate(180deg)';
            }
        });
    });
}

function close(button) {
    const content = button.nextElementSibling;
    const chevron = button.querySelector('.chevron');
    content.style.maxHeight = '';
    chevron.style.transform = 'rotate(0deg)';
}