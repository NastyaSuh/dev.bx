export class Item
{
	title;
	deleteButtonHandler;
	changeButtonHandler;

	constructor({ title, deleteButtonHandler, changeButtonHandler })
	{
		this.title = String(title);
		if (typeof deleteButtonHandler === 'function')
		{
			this.deleteButtonHandler = deleteButtonHandler;
		}
		if (typeof changeButtonHandler === 'function')
		{
			this.changeButtonHandler = changeButtonHandler;
		}
	}

	getData()
	{
		return { title: this.title };
	}

	render()
	{
		const container = document.createElement('div');
		container.classList.add('item-container');
		const title = document.createElement('div');
		title.classList.add('item-title');
		title.innerText = this.title;
		container.append(title);

		const buttonsContainer = document.createElement('div');
		const deleteButton = document.createElement('button');
		const changeButton = document.createElement('button');

		deleteButton.innerText = 'Delete';
		buttonsContainer.append(deleteButton);
		deleteButton.addEventListener('click', this.handleDeleteButton.bind(this));

		changeButton.innerText = 'Edit';
		changeButton.classList.add('changeButton');
		buttonsContainer.append(changeButton);
		changeButton.addEventListener('click', this.handleChangeButton.bind(this));

		container.append(buttonsContainer);
		return container;
	}

	handleDeleteButton()
	{
		if (this.deleteButtonHandler)
		{
			this.deleteButtonHandler(this);
		}
	}

	handleChangeButton()
	{
		if (this.changeButtonHandler)
		{
			this.changeButtonHandler(this);
		}
	}
}
