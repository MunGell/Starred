import React from 'react'

export default React.createClass({

    _onSubmit: function (event) {
        event.preventDefault();
        this.props.onTagAdd(event.currentTarget[0].value);
        event.currentTarget[0].value = '';
    },

    render: function () {
        return (
            <div className="component__tag-manager__form">
                <form onSubmit={this._onSubmit}>
                    <label for="tagInput" className="sr-only">Add a tag</label>
                    <input type="text" name="title" className="form-control" id="tagInput" placeholder="Add a tag"/>
                </form>
            </div>
        )
    }
});