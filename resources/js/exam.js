
export function write(alias, form) {
  const answers = JSON.parse(localStorage.getItem(alias+'answers')) || [];

  const itemIndex = answers.findIndex(item => item.id === form.id);

  if (itemIndex !== -1) {
    answers[itemIndex] = form;
  }else {
    answers.push(form);
  }

  localStorage.setItem(alias+'answers', JSON.stringify(answers));
}

export function remove(alias, id, index) {
  const answers = JSON.parse(localStorage.getItem(alias+'answers'));
  const itemIndex = answers.findIndex(item => item.id === id);
  answers[itemIndex].image.splice(index, 1);
  localStorage.setItem(alias+'answers', JSON.stringify(answers));
}