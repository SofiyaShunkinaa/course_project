function addCollectionAttribute(){
    const collectionHolder = document.querySelector('#custom-attributes-wrapper');
    const item = document.createElement('li');
    item.className = 'item'
  
    item.innerHTML = collectionHolder
      .dataset
      .prototype
      .replace(
        /__name__/g,
        collectionHolder.dataset.index
      );
  
    collectionHolder.appendChild(item);
  
    collectionHolder.dataset.index++;
}

function addRemoveAttributeButton(){

}

document.addEventListener('DOMContentLoaded', ()=>{
    document
    .querySelector('#add-custom-attribute')
    .addEventListener('click', (e)=>{
        e.preventDefault()

        addCollectionAttribute()
    })
})