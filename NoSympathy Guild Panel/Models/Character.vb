Public Class Character
    'Guild
    Private _Name As String
    Private _Rank As String
    Private _Joined As String

    'Character
    Private _ID As String
    Private _Race As String
    Private _Gender As String
    Private _Profession As String
    ' private _Guild As String ' The guild ID of the character's currently represented guild.
    Private _Level As Integer 'The character's level
    Private _Created As String 'ISO 8601 representation of the character's creation time.
    Private _Age As String 'The amount of seconds this character was played.
    Private _Deaths As String 'The amount of times this character has been defeated.
    Private _Crafting As List(Of Crafting) 'A list of objects of the character's crafting skills. An empty array is returned if the character has not learned a crafting discipline yet.

    Public Property Name() As String
        Get
            Return _Name
        End Get
        Set(value As String)
            Me._Name = value
        End Set
    End Property

    Public Property Rank() As String
        Get
            Return _Rank
        End Get
        Set(value As String)
            Me._Rank = value
        End Set
    End Property
    Public Property Joined() As String
        Get
            Return _Joined
        End Get
        Set(value As String)
            Me._Joined = value
        End Set
    End Property

    'Character
    Public Property ID() As String
        Get
            Return _ID
        End Get
        Set(value As String)
            Me._ID = value
        End Set
    End Property
    Public Property Race() As String
        Get
            Return _Race
        End Get
        Set(value As String)
            Me._Race = value
        End Set
    End Property
    Public Property Gender() As String
        Get
            Return _Gender
        End Get
        Set(value As String)
            Me._Gender = value
        End Set
    End Property
    Public Property Profession() As String
        Get
            Return _Profession
        End Get
        Set(value As String)
            Me._Profession = value
        End Set
    End Property
    ' Public Property Guild() As String ' The guild ID of the character's currently represented guild.
    Public Property Level() As Integer 'The character's level
        Get
            Return _Level
        End Get
        Set(value As Integer)
            Me._Level = value
        End Set
    End Property
    Public Property Created() As String 'ISO 8601 representation of the character's creation time.
        Get
            Return _Created
        End Get
        Set(value As String)
            Me._Created = value
        End Set
    End Property
    Public Property Age() As String 'The amount of seconds this character was played.
        Get
            Return _Age
        End Get
        Set(value As String)
            Me._Age = value
        End Set
    End Property
    Public Property Deaths() As String 'The amount of times this character has been defeated.
        Get
            Return _Deaths
        End Get
        Set(value As String)
            Me._Deaths = value
        End Set
    End Property
    Public Property Crafting() As List(Of Crafting) 'A list of objects of the character's crafting skills. An empty array is returned if the character has not learned a crafting discipline yet.
        Get
            Return _Crafting
        End Get
        Set(value As List(Of Crafting))
            Me._Crafting = value
        End Set
    End Property
End Class
