// пишем export, чтобы можно было использовать этот файл в других файлах
import { Item } from './item.js';

export class List
{
	//container = нода, где лежит весь html, то есть по сути пишем шаблонизатор
	container;
	items;
	itemsListContainer;
	//флаг - ajax уже выполняется
	isProgress = false;
	loading;
	//флаг - изменяем todo item
	isEditing;
	inputText;
	currentPosition;
	successfulEditing;

	constructor({ container })
	{
		this.container = container;
		this.items = [];

		this.inputText = '';
		this.currentPosition = -1;

		this.successfulEditing = document.createElement('label');
		this.successfulEditing.classList.add('popup-text');
		this.successfulEditing.id = 'popup';
		this.successfulEditing.style.color = 'OliveDrab';
		this.container.append(this.successfulEditing);

		this.itemsListContainer = document.createElement('div');
		this.itemsListContainer.classList.add('item-container');
		this.container.append(this.itemsListContainer);

		this.loading = document.createElement('div');
		this.loading.classList.add('hidden');
		this.loading.innerText = 'Loading...';
		this.container.append(this.loading);

		this.isProgress = false;
		this.isEditing = false;
	}

	render()
	{
		this.load()
			.then(({ items }) => {
				if (Array.isArray(items))
				{
					items.forEach((itemData) => {
						this.items.push(this.createItems(itemData));
					});
				}
				this.renderItems();
			})
			.catch((result) => {
				console.error('error trying to load items: ' + result);
			});

		this.container.append(this.renderActions());
	}

	renderItems()
	{
		this.itemsListContainer.innerHTML = ' ';
		this.items.forEach((item) => {
				this.itemsListContainer.append(item.render());
			},
		);
	}

	renderActions()
	{
		const actionsContainer = document.createElement('div');
		const addContainer = document.createElement('div');
		const addInput = document.createElement('input');
		const addButton = document.createElement('button');

		addInput.classList.add('calendar-new-item-title');
		addButton.innerText = 'add';
		addButton.classList.add('add-button');
		this.inputText = addInput;
		addButton.addEventListener('click', this.handleAddButtonClick.bind(this));
		this.inputText.placeholder = 'Введите что-нибудь';

		addContainer.append(addInput);
		addContainer.append(addButton);
		actionsContainer.append(addContainer);

		return actionsContainer;
	}

	createItems(itemData)
	{
		itemData.deleteButtonHandler = this.handleDeleteButton.bind(this);
		itemData.changeButtonHandler = this.handleEditButton.bind(this);
		return new Item(itemData);
	}

	handleAddButtonClick()
	{
		if (this.isEditing)
		{
			this.editItem();
		}
		else
		{
			this.add();
		}
	}

	handleDeleteButton(item)
	{
		const index = this.items.indexOf(item);
		if (index > -1)
		{
			this.items.splice(index, 1);
			this.save().then(() => {
				this.renderItems();
			}).catch((error) => {
				console.error('error trying to delete item');
			});
		}
	}

	handleEditButton(item)
	{
		const index = this.items.indexOf(item);
		if (index > -1)
		{
			this.currentPosition = index;
			this.isEditing = true;
			this.inputText.value = this.items[index].title;
			this.toggleButton();

		}
	}

	toggleButton()
	{
		const buttonClass = this.container.querySelector('.add-button').firstChild;
		buttonClass.data = buttonClass.data === 'add' ? 'save' : 'add';
	}

	editItem()
	{
		const position = this.currentPosition;
		this.items[position].title = this.inputText.value;
		this.save().then(() => {
				this.renderItems();
				this.inputText.value = '';
				this.toggleButton();
				this.isEditing = false;
				this.successful_editing();
			})
			.catch((error) => {
				console.error('error trying save items: ' + error);
			});
	}

	add()
	{
		const addInput = this.container.querySelector('.calendar-new-item-title');
		if (addInput)
		{
			if (addInput.value.length === 0 || addInput.value === ' ')
			{
				return;
			}
			this.items.push(this.createItems(new Item({ title: addInput.value })));
			addInput.value = '';
			this.save().then(() => {
				this.renderItems();
				addInput.value = '';
			}).catch((error) => {
				console.error('error trying save items: ' + error);
			});
		}
	}

	load()
	{
		return new Promise(((resolve, reject) => {
			if (this.isProgress)
			{
				reject('more than 1 ajax query');
				return;
			}
			this.startProgress();
			return fetch(
				'/dev.bx/java%20script/18.11/ajax.php?action=load',
				{
					method: 'POST',
				},
			).then((response) => {
				return response.json();
			}).then((result) => {
				if (result.error)
				{
					reject(result.error);
					return;
				}
				return resolve(result);
			}).catch((result) => {
				reject(result);
			}).finally(() => {
				this.stopProgress();
			});
		}));
	}

	//finally выполняется всегда

	save()
	{
		return new Promise(((resolve, reject) => {
			if (this.isProgress)
			{
				reject('more than 1 ajax query');
				return;
			}
			this.startProgress();
			const data = { items: [] };

			this.items.forEach((item) => {
				data.items.push(item.getData());
			});

			return fetch(
				'/dev.bx/java%20script/18.11/ajax.php?action=save',
				{
					method: 'POST',
					headers: {
						'Content-Type': 'application/json;charset=utf-8',
					},
					body: JSON.stringify(data),
				})
				.then((response) => {
					return response.json();
				})
				.then((result) => {
					if (result.error)
					{
						reject(result.error);
						return;
					}
					return resolve(result);
				})
				.catch((result) => {
					reject(result);
				}).finally(() => {
					this.stopProgress();
				});
		}));
	}

	startProgress()
	{
		//показывает что идет загрузка
		this.isProgress = true;
		this.loading.classList.remove('hidden');
	}

	stopProgress()
	{
		this.isProgress = false;
		this.loading.classList.add('hidden');
	}

	successful_editing()
	{
		this.successfulEditing.style.display = 'block';
		this.successfulEditing.innerText = 'The editing proceeded successfully';
		setTimeout(this.removePopup, 2000);
	}

	removePopup()
	{
		document.getElementById('popup').style.display = 'none';
	}
}