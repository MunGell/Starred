import $ from 'jquery'
import _ from 'lodash'
import React from 'react'

export default React.createClass({

    getDefaultProps: function () {
        return {
            currentPage: 1,
            lastPage: 1,
            nextPageUrl: null,
            prevPageUrl: null
        }
    },

    render: function () {
        return (
            <nav>
                <ul className="component-paginator pagination">
                {( this.props.currentPage !== 1 ?
                    <li className="component-paginator__item component-paginator__item--prev">
                        <a href={'/#/repositories/?page=' + (this.props.currentPage - 1)}  aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    : ''
                )}
                    {_.range(this.props.currentPage - 5, this.props.currentPage + 5).map(function (value) {
                        var isActive = (value === this.props.currentPage) ? ' active' : '';
                        if (value > 0 && value <= this.props.lastPage) {
                            return (
                                <li className={'component-paginator__item' + isActive}>
                                    <a href={'/#/repositories/?page=' + value} >{value}</a>
                                </li>
                            )
                        }
                    }.bind(this))}
                    {( this.props.currentPage !== this.props.lastPage ?
                        <li className="component-paginator__item component-paginator__item--next">
                            <a href={'/#/repositories/?page=' + (this.props.currentPage + 1)} aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        : ''
                    )}
                </ul>
            </nav>
        )
    }
});