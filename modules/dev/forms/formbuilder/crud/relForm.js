$scope.changeRelation = function(item, ref) {
    item.tableName = ref.tableName;
    item.type = ref.type;
    item.foreignKey = ref.foreignKey;
    item.className = ref.className;
}